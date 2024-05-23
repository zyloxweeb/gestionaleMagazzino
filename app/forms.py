from flask_wtf import FlaskForm
from wtforms import StringField, IntegerField, DateField
from wtforms.validators import DataRequired

class ProdottoForm(FlaskForm):
    nome = StringField('Nome', validators=[DataRequired()])
    quantita = IntegerField('Quantità', validators=[DataRequired()])
    scadenza = DateField('Data di Scadenza', validators=[DataRequired()])
    lotto = StringField('Lotto', validators=[DataRequired()])
