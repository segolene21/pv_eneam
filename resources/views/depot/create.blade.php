@extends('layouts.inapp')

@section('content')
<h4 class="mb-3">Déposer des PV</h4>

<div id="zone" class="rounded p-5 text-center mb-3" style="border:2px dashed #bbb; cursor:pointer">
    <p class="mb-1">Glissez vos PV ici (PDF ou images)</p>
    <small class="text-muted">ou cliquez pour les choisir</small>
    <input type="file" id="choix" multiple accept=".pdf,.jpg,.jpeg,.png" hidden>
</div>

<table class="table align-middle" id="liste" hidden>
    <thead>
        <tr><th>Fichier</th><th>Année</th><th>Filière</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody></tbody>
</table>

<button id="archiver" class="btn btn-primary" hidden>Archiver tout</button>

<script>
const filieres = @json($filieres->pluck('nom', 'code'));
const annees = @json($annees);
const url = "{{ route('depot.store') }}";
const token = "{{ csrf_token() }}";

const zone = document.getElementById('zone');
const choix = document.getElementById('choix');
const liste = document.getElementById('liste');
const corps = liste.querySelector('tbody');
const bouton = document.getElementById('archiver');
const lignes = [];

zone.addEventListener('click', () => choix.click());
zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.background = '#f5f5f5'; });
zone.addEventListener('dragleave', () => { zone.style.background = ''; });
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.style.background = '';
    ajouter(e.dataTransfer.files);
});
choix.addEventListener('change', () => { ajouter(choix.files); choix.value = ''; });

function detecter(nom) {
    const m = nom.match(/(\d{4})\s*[-_\/]\s*(\d{4})/);
    const annee = m ? m[1] + '-' + m[2] : '';
    const mots = nom.toUpperCase().split(/[^A-Z0-9]+/);
    const code = Object.keys(filieres).find(c => mots.includes(c.toUpperCase())) || '';
    return { annee, code };
}

function ajouter(fichiers) {
    [...fichiers].forEach(f => {
        const d = detecter(f.name);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="nom"></td>
            <td><select class="form-select form-select-sm annee">
                <option value="">—</option>
                ${annees.map(a => `<option ${a === d.annee ? 'selected' : ''}>${a}</option>`).join('')}
            </select></td>
            <td><select class="form-select form-select-sm filiere">
                <option value="">—</option>
                ${Object.entries(filieres).map(([c, n]) => `<option value="${c}" ${c === d.code ? 'selected' : ''}>${n}</option>`).join('')}
            </select></td>
            <td class="statut">${d.annee && d.code ? 'Prêt' : 'À compléter'}</td>
            <td><button type="button" class="btn btn-sm btn-outline-secondary retirer">✕</button></td>`;
        tr.querySelector('.nom').textContent = f.name;
        corps.appendChild(tr);
        lignes.push({ f, tr, fait: false });

        tr.querySelector('.retirer').addEventListener('click', () => {
            lignes.splice(lignes.findIndex(l => l.tr === tr), 1);
            tr.remove();
            if (!lignes.length) { liste.hidden = true; bouton.hidden = true; }
        });
    });
    liste.hidden = false;
    bouton.hidden = false;
}

bouton.addEventListener('click', async () => {
    bouton.disabled = true;
    for (const l of lignes) {
        if (l.fait) continue;
        const annee = l.tr.querySelector('.annee').value;
        const code = l.tr.querySelector('.filiere').value;
        const statut = l.tr.querySelector('.statut');
        if (!annee || !code) { statut.textContent = 'À compléter'; continue; }

        statut.textContent = 'Envoi…';
        const fd = new FormData();
        fd.append('_token', token);
        fd.append('annee', annee);
        fd.append('filiere_code', code);
        fd.append('fichier', l.f);

        const r = await fetch(url, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
        if (r.ok) {
            statut.textContent = 'Archivé ✔';
            l.fait = true;
            l.tr.querySelector('.retirer').hidden = true;
        } else {
            const e = await r.json().catch(() => ({}));
            statut.textContent = (e.errors && Object.values(e.errors)[0][0]) || e.message || 'Erreur';
        }
    }
    bouton.disabled = false;
});
</script>
@endsection