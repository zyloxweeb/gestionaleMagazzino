import os

class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY') or 'dawdaw dada'
    SQLALCHEMY_DATABASE_URI = os.environ.get('DATABASE_URL') or 'sqlite:///magazzino.db'
    SQLALCHEMY_TRACK_MODIFICATIONS = False
