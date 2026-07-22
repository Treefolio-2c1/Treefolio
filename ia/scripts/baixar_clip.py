from transformers import CLIPModel, CLIPProcessor

print("Baixando modelo CLIP...")

modelo = CLIPModel.from_pretrained("openai/clip-vit-base-patch32")
processador = CLIPProcessor.from_pretrained("openai/clip-vit-base-patch32")

modelo.save_pretrained("ia/modelos/clip")
processador.save_pretrained("ia/modelos/clip")

print("Modelo salvo em ia/modelos/clip!")