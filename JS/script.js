document.addEventListener("DOMContentLoaded", function() {
    const todoList = document.getElementById('todo-list');
    if (!todoList) {
        console.error('Element with ID "todo-list" not found.');
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
                    console.log('Processing item:', item); // Log each item processed
                    const listItem = document.createElement('div');
                    listItem.textContent = item.titre + ': ' + item.description; // assuming 'titre' and 'description' are properties of the todo
                    console.log('Adding item to DOM:', listItem.textContent); // Log each item added
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
});
