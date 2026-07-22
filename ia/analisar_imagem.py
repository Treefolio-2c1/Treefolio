from transformers import CLIPModel, CLIPProcessor

modelo = None
processador = None

def carregar_modelo():
    global modelo, processador

    if modelo is None:
        print("Carregando modelo CLIP...")
        modelo = CLIPModel.from_pretrained("ia/modelos/clip")
        processador = CLIPProcessor.from_pretrained("ia/modelos/clip")
        print("Modelo carregado")

    return modelo, processador