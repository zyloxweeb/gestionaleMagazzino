from flask import render_template, request, redirect, url_for, flash
from . import db
from .models import Prodotto
from .forms import ProdottoForm
from datetime import datetime
from flask import current_app as app

@app.route('/')
def home():
    prodotti_in_scadenza = Prodotto.query.filter(Prodotto.scadenza <= datetime.today().date()).all()
    return render_template('home.html', prodotti=prodotti_in_scadenza)

@app.route('/add', methods=['GET', 'POST'])
def add_product():
    form = ProdottoForm()
    if form.validate_on_submit():
        nuovo_prodotto = Prodotto(
            nome=form.nome.data,
            quantita=form.quantita.data,
            scadenza=form.scadenza.data,
            lotto=form.lotto.data
        )
        db.session.add(nuovo_prodotto)
        db.session.commit()
        flash('Prodotto aggiunto con successo!')
        return redirect(url_for('home'))
    return render_template('add_product.html', form=form)

@app.route('/edit/<int:id>', methods=['GET', 'POST'])
def edit_product(id):
    prodotto = Prodotto.query.get_or_404(id)
    form = ProdottoForm(obj=prodotto)
    if form.validate_on_submit():
        prodotto.nome = form.nome.data
        prodotto.quantita = form.quantita.data
        prodotto.scadenza = form.scadenza.data
        prodotto.lotto = form.lotto.data
        db.session.commit()
        flash('Prodotto aggiornato con successo!')
        return redirect(url_for('home'))
    return render_template('edit_product.html', form=form, prodotto=prodotto)
