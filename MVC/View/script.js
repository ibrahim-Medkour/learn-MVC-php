const form = document.querySelector('#genre-form');
const nameInput = document.querySelector('#nom');
const submitButton = document.querySelector('#submit-button');
const buttonLabel = submitButton.querySelector('.button-label');
const genreList = document.querySelector('#genre-list');
const genreCount = document.querySelector('#genre-count');
const toastContainer = document.querySelector('#toast-container');

const listUrl = '../Controller/GenreController.php?action=list';
const createUrl = '../Controller/GenreController.php?action=create';

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
    toast.textContent = message;
    toastContainer.append(toast);

    window.setTimeout(() => {
        toast.classList.add('toast-hiding');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        window.setTimeout(() => toast.remove(), 300);
    }, 3500);
}

async function requestJson(url, options = {}) {
    let response;

    try {
        response = await fetch(url, options);
    } catch {
        throw new Error('Impossible de joindre le serveur. Vérifiez votre connexion.');
    }

    let result;
    try {
        result = await response.json();
    } catch {
        throw new Error('Le serveur a retourné une réponse invalide.');
    }

    if (!response.ok || result.success !== true) {
        throw new Error(result.message || 'La requête a échoué.');
    }

    return result;
}

function renderGenres(genres) {
    genreList.replaceChildren();
    genreCount.textContent = String(genres.length);

    if (genres.length === 0) {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 2;
        cell.className = 'table-message';
        cell.textContent = 'Aucun genre pour le moment. Ajoutez votre premier genre ci-dessus.';
        row.append(cell);
        genreList.append(row);
        return;
    }

    for (const genre of genres) {
        const row = document.createElement('tr');
        const idCell = document.createElement('td');
        const nameCell = document.createElement('td');
        idCell.textContent = String(genre.id);
        idCell.className = 'id-cell';
        nameCell.textContent = genre.nom;
        row.append(idCell, nameCell);
        genreList.append(row);
    }
}

async function loadGenres() {
    genreList.innerHTML = '<tr><td colspan="2" class="table-message">Chargement des genres…</td></tr>';

    try {
        const result = await requestJson(listUrl);
        if (!Array.isArray(result.data)) {
            throw new Error('Le serveur a retourné une liste invalide.');
        }
        renderGenres(result.data);
    } catch (error) {
        genreCount.textContent = '—';
        genreList.innerHTML = '<tr><td colspan="2" class="table-message">Les genres ne peuvent pas être chargés.</td></tr>';
        showToast(error.message, 'error');
    }
}

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const nom = nameInput.value.trim();

    if (nom === '') {
        showToast('Veuillez saisir le nom du genre.', 'warning');
        nameInput.focus();
        return;
    }

    submitButton.disabled = true;
    submitButton.classList.add('is-loading');
    buttonLabel.textContent = 'Ajout en cours…';

    try {
        const result = await requestJson(createUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom }),
        });

        form.reset();
        showToast(result.message || 'Genre ajouté avec succès', 'success');
        await loadGenres();
        nameInput.focus();
    } catch (error) {
        showToast(error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.classList.remove('is-loading');
        buttonLabel.textContent = 'Ajouter';
    }
});

loadGenres();