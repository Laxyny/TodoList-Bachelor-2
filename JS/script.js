document.addEventListener("DOMContentLoaded", function () {
    const todoList = document.getElementById('todo-list');
    const loginForm = document.getElementById('loginForm');
    const loginError = document.getElementById('loginError');
    const registerForm = document.getElementById('registerForm');
    const registerError = document.getElementById('registerError');
    const logoutButton = document.getElementById('logoutButton');
    const todoForm = document.getElementById('todoForm');
    const todoTitle = document.getElementById('todoTitle');
    const todoDescription = document.getElementById('todoDescription');
    const todoDueDate = document.getElementById('todoDueDate');

    if (!todoList) {
        console.error('Element with ID "todo-list" not found.');
        return;
    }

    function showLoginForm() {
        loginForm.style.display = 'block';
        registerForm.style.display = 'block';
        logoutButton.style.display = 'none';
        todoForm.style.display = 'none';
        todoList.innerHTML = '';
    }

    function showLogoutButton() {
        loginForm.style.display = 'none';
        registerForm.style.display = 'none';
        logoutButton.style.display = 'block';
        todoForm.style.display = 'block';
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
                    showLogoutButton();
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

    logoutButton.addEventListener('click', function () {
        localStorage.removeItem('userId');
        showLoginForm();
    });

    todoForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const title = todoTitle.value;
        const description = todoDescription.value;
        const dueDate = todoDueDate.value;
        const userId = localStorage.getItem('userId');

        const requestData = { title, description, dueDate, userId };
        console.log('Sending todo data:', requestData);

        fetch('controllers/TodoPostController.php', {
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
                fetchTodos(userId);
                todoTitle.value = '';
                todoDescription.value = '';
                todoDueDate.value = '';
            } else {
                console.error('Error adding todo:', data.error);
            }
        })
        .catch(error => {
            console.error('Error adding todo:', error);
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
        showLogoutButton();
        fetchTodos(storedUserId);
    } else {
        showLoginForm();
    }
});
