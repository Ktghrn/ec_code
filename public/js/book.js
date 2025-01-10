document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('book-form');
  form.addEventListener('submit', function (event) {
      event.preventDefault(); // Empêche l'envoi traditionnel du formulaire

      const data = new FormData(form);
      const url = form.action; // Utilise l'URL définie dans l'attribut 'action' du formulaire

      // Soumettre les données du formulaire en AJAX
      fetch(url, {
          method: 'POST',
          body: data,
      })
      .then(function (response) {
          return response.json(); // Transformer la réponse en JSON
      })
      .then(function (data) {
          if (data.success) {
              // Si la soumission réussit, afficher un message et fermer la modale
              alert('Livre ajouté avec succès !');
              const modal = document.getElementById('book_modal');
              modal.style.display = 'none'; // Fermer la modale

              // Mettre à jour le tableau des livres (si nécessaire)
              const table = document.getElementById('books-table-body');
              const row = document.createElement('tr');
              row.innerHTML = `
                  <td>${data.book.id}</td>
                  <td>${data.book.name}</td>
                  <td>${data.book.description}</td>
                  <td>${data.book.rating}</td>
                  <td>${data.book.completed ? 'Oui' : 'Non'}</td>
              `;
              table.appendChild(row);
          } else {
              // Si la soumission échoue, afficher une alerte
              alert('Erreur lors de l\'ajout du livre.');
          }
      })
      .catch(function (error) {
          alert('Une erreur s\'est produite.');
      });
  });
});
