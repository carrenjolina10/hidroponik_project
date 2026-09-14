import torch
import torch.nn as nn
import torchvision
from torchvision import transforms
from PIL import Image
import io
from fastapi import FastAPI, UploadFile, File
from ultralytics import YOLO
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://127.0.0.1:8001",
        "http://localhost:8001",
    ],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

DISEASE_CLASSES = [
    'Bacterial',
    'Downy_mildew_on_lettuce',
    'Powdery_mildew_on_lettuce',
    'Septoria_Blight_on_lettuce',
    'Viral',
    'Wilt_and_leaf_blight_on_lettuce',
    'healthy'
]

# ---- Definisikan arsitektur classifier (harus sama persis dengan saat training) ----
class LettuceClassifier(nn.Module):
    def __init__(self, num_classes=7):
        super().__init__()
        self.backbone = torchvision.models.efficientnet_b0(weights=None)
        in_features = self.backbone.classifier[1].in_features
        self.backbone.classifier[1] = nn.Linear(in_features, num_classes)

    def forward(self, x):
        return self.backbone(x)

# ---- Load kedua model saat server start ----
device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

yolo_model = YOLO("best_final.pt")

classifier = LettuceClassifier(num_classes=len(DISEASE_CLASSES))
ckpt = torch.load("best_lettuce_disease_model_final.pth", map_location=device, weights_only=False)
classifier.load_state_dict(ckpt["model_state_dict"])
classifier.to(device)
classifier.eval()

# ---- Preprocessing untuk classifier (standar ImageNet, EfficientNet-B0) ----
preprocess = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225]),
])

@app.get("/")
def root():
    return {"status": "ok", "message": "Lettuce disease AI service is running"}

@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    image_bytes = await file.read()
    image = Image.open(io.BytesIO(image_bytes)).convert("RGB")

    # 1. Deteksi daun pakai YOLO
    results = yolo_model.predict(image, imgsz=640, verbose=False)
    boxes = results[0].boxes

    if len(boxes) == 0:
        # Kalau YOLO tidak menemukan daun, tetap coba klasifikasi seluruh gambar
        crop = image
    else:
        # Ambil box dengan confidence tertinggi
        best_box = boxes[boxes.conf.argmax()]
        x1, y1, x2, y2 = map(int, best_box.xyxy[0].tolist())
        crop = image.crop((x1, y1, x2, y2))

    # 2. Klasifikasi penyakit dari hasil crop
    input_tensor = preprocess(crop).unsqueeze(0).to(device)
    with torch.no_grad():
        output = classifier(input_tensor)
        probs = torch.softmax(output, dim=1)[0]
        pred_idx = torch.argmax(probs).item()
        confidence = probs[pred_idx].item()

    return {
        "disease": DISEASE_CLASSES[pred_idx],
        "confidence": round(confidence, 4),
        "leaf_detected": len(boxes) > 0,
        "all_probabilities": {
            DISEASE_CLASSES[i]: round(probs[i].item(), 4) for i in range(len(DISEASE_CLASSES))
        }
    }

