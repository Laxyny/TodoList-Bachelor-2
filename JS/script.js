document.addEventListener("DOMContentLoaded", function() {
    const todoList = document.getElementById('todo-list');
    const utilisateur = document.getElementById('utilisateur');
    if (!todoList || !utilisateur) {
        console.error('Element not found.');
        return;
    }
    
    fetch('controllers/TodoGetController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received from API:', data); // Log data for debugging
            todoList.innerHTML = ''; // Clear any existing content
            if (data.error) {
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Error: ' + data.error;
                todoList.appendChild(errorItem);
            } else {
                data.forEach(item => {
                    console.log('Processing item:', item);
                    const listItem = document.createElement('div');

                    listItem.textContent = item.titre + ': ' + item.description + ' date création: ' + item.date_creation + ' date échéance: ' + item.date_creation
                    + ' id utilisateur: ' + item.id_utilisateur

                    console.log('Adding item to DOM:', listItem.textContent);
                    todoList.appendChild(listItem);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching todo list:', error);
            const errorItem = document.createElement('div');
            errorItem.textContent = 'Error: ' + error.message;
            todoList.appendChild(errorItem);
        });

        
        
        fetch('controllers/UtilisateurGetController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received from API:', data); // Log data for debugging
            utilisateur.innerHTML = ''; // Clear any existing content
            if (data.error) {
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Error: ' + data.error;
                utilisateur.appendChild(errorItem);
            } else {
                data.forEach(item => {
                    console.log('Processing item:', item);
                    const listItem = document.createElement('div');
                    listItem.textContent = item.id_utilisateur + ': ' + item.email + ' ' + item.mot_de_passe;
                    console.log('Adding item to DOM:', listItem.textContent);
                    utilisateur.appendChild(listItem);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching utilisateurs list:', error);
            const errorItem = document.createElement('div');
            errorItem.textContent = 'Error: ' + error.message;
            utilisateur.appendChild(errorItem);
        });
});