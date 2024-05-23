from . import db

class Prodotto(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nome = db.Column(db.String(100), nullable=False)
    quantita = db.Column(db.Integer, nullable=False)
    scadenza = db.Column(db.Date, nullable=False)
    lotto = db.Column(db.String(50), nullable=False)
