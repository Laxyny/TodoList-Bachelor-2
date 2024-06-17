document.addEventListener("DOMContentLoaded", function () {
    const todoList = document.getElementById('todo-list');
    const loginForm = document.getElementById('loginForm');
    const loginError = document.getElementById('loginError');
    const registerForm = document.getElementById('registerForm');
    const registerError = document.getElementById('registerError');

    if (!todoList) {
        console.error('Element with ID "todo-list" not found.');
        return;
    }

    registerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('registerEmail').value;
        const password = document.getElementById('registerPassword').value;

        const requestData = { email, password };
        console.log('Sending register data:', requestData);

        fetch('controllers/RegisterController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                registerForm.style.display = 'none';
            } else {
                registerError.textContent = data.error;
            }
        })
        .catch(error => {
            console.error('Error during registration:', error);
        });
    });

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;

        const requestData = { email, password };
        console.log('Sending login data:', requestData);

        fetch('controllers/LoginPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    localStorage.setItem('userId', data.userId);
                    loginForm.style.display = 'none';
                    fetchTodos(data.userId);
                } else {
                    loginError.textContent = data.error;
                }
            } catch (error) {
                console.error('Error parsing JSON:', error, 'Response:', text);
                loginError.textContent = 'Invalid server response';
            }
        })
        .catch(error => {
            console.error('Error during login:', error);
            loginError.textContent = 'Network error';
        });
    });

    function fetchTodos(userId) {
        fetch(`controllers/TodoGetController.php?userId=${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received from API:', data);
            todoList.innerHTML = '';
            if (data.error) {
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Error: ' + data.error;
                todoList.appendChild(errorItem);
            } else {
                data.forEach(item => {
                    const listItem = document.createElement('div');
                    listItem.textContent = `${item.titre}: ${item.description} date création: ${item.date_creation} date échéance: ${item.date_echeance}`;
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
    }

    const storedUserId = localStorage.getItem('userId');
    if (storedUserId) {
        fetchTodos(storedUserId);
    }
});
