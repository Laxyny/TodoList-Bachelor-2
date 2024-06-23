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
    const todoStatus = document.getElementById('todoStatus');
    const todoPriority = document.getElementById('todoPriority');

    const adminPanel = document.getElementById('adminPanel');
    const listUsersButton = document.getElementById('listUsersButton');
    const userList = document.getElementById('userList');
    const createUserForm = document.getElementById('createUserForm');
    const createUserUtilisateur = document.getElementById('createUserUtilisateur');
    const createUserPassword = document.getElementById('createUserPassword');
    const createUserRole = document.getElementById('createUserRole');

    const listStatusesButton = document.getElementById('listStatusesButton');
    const statusList = document.getElementById('statusList');
    const createStatusForm = document.getElementById('createStatusForm');
    const createStatusName = document.getElementById('createStatusName');

    const deletedTodoList = document.getElementById('deletedTodoList');
    const restaurerDeletedTodosButton = document.getElementById('restaurerDeletedTodosButton');

    if (!todoList) {
        console.error('Element with ID "todo-list" not found.');
        return;
    }

    function showLoginForm() {
        loginForm.style.display = 'block';
        registerForm.style.display = 'block';
        logoutButton.style.display = 'none';
        todoForm.style.display = 'none';
        adminPanel.style.display = 'none';
        todoList.innerHTML = '';
    }

    function showLogoutButton() {
        loginForm.style.display = 'none';
        registerForm.style.display = 'none';
        logoutButton.style.display = 'block';
        todoForm.style.display = 'block';
    }

    function showAdminPanel() {
        adminPanel.style.display = 'block';
    }

    registerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const utilisateur = document.getElementById('registerUtilisateur').value;
        const password = document.getElementById('registerPassword').value;

        const requestData = { utilisateur, password };
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

        const utilisateur = document.getElementById('loginUtilisateur').value;
        const password = document.getElementById('loginPassword').value;

        const requestData = { utilisateur, password };
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
            return response.json();
        })
        .then(data => {
            if (data.success) {
                localStorage.setItem('userId', data.userId);
                localStorage.setItem('userRole', data.role);
                showLogoutButton();
                fetchTodos(data.userId);
                if (data.role === 'admin') {
                    showAdminPanel();
                }
            } else {
                loginError.textContent = data.error;
            }
        })
        .catch(error => {
            console.error('Error during login:', error);
            loginError.textContent = 'Network error';
        });
    });

    logoutButton.addEventListener('click', function () {
        localStorage.removeItem('userId');
        localStorage.removeItem('userRole');
        showLoginForm();
    });

    todoForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const title = todoTitle.value;
        const description = todoDescription.value;
        const dueDate = todoDueDate.value;
        const statusId = todoStatus.value;
        const priorityId = todoPriority.value;
        const userId = localStorage.getItem('userId');

        const requestData = { action: 'add_todo', title, description, dueDate, statusId, priorityId, userId };
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
                todoStatus.value = '';
                todoPriority.value = '';
            } else {
                console.error('Error adding todo:', data.error);
            }
        })
        .catch(error => {
            console.error('Error adding todo:', error);
        });
    });

    listUsersButton.addEventListener('click', function () {
        fetch('controllers/AdminController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'list_users' })
        })
        .then(response => response.json())
        .then(data => {
            userList.innerHTML = '';
            data.forEach(user => {
                const userItem = document.createElement('div');
                userItem.textContent = `${user.utilisateur} (${user.role})`;
                userList.appendChild(userItem);
            });
        })
        .catch(error => console.error('Error listing users:', error));
    });

    createUserForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const utilisateur = createUserUtilisateur.value;
        const password = createUserPassword.value;
        const role = createUserRole.value;

        const requestData = { action: 'create_user', utilisateur, password, role };
        fetch('controllers/AdminController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createUserUtilisateur.value = '';
                createUserPassword.value = '';
                createUserRole.value = 'user';
                listUsersButton.click();
            } else {
                console.error('Error creating user:', data.error);
            }
        })
        .catch(error => console.error('Error creating user:', error));
    });

    listStatusesButton.addEventListener('click', function () {
        fetch('controllers/StatutGetController.php')
        .then(response => response.json())
        .then(data => {
            statusList.innerHTML = '';
            data.forEach(status => {
                const statusItem = document.createElement('div');
                statusItem.textContent = status.libelle;
                statusList.appendChild(statusItem);
            });
        })
        .catch(error => console.error('Error listing statuses:', error));
    });

    createStatusForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = createStatusName.value;

        const requestData = { action: 'create_statut', name };
        fetch('controllers/StatutPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createStatusName.value = '';
                listStatusesButton.click();
            } else {
                console.error('Error creating status:', data.error);
            }
        })
        .catch(error => console.error('Error creating status:', error));
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
                    if (item.id_statut != 4) {
                        const listItem = document.createElement('div');
                        listItem.innerHTML = `<strong>${item.titre}</strong>: ${item.description} (Créé le ${item.date_creation}, Échéance: ${item.date_echeance})<br>Status: ${item.libelle_statut}, Priority: ${item.libelle_priorite}`;
                        const editButton = document.createElement('button');
                        editButton.textContent = 'Edit';
                        editButton.addEventListener('click', function () {
                            editTodoStatus(item.id_todo, item.libelle_statut, item.libelle_priorite);
                        });
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete';
                        deleteButton.addEventListener('click', function () {
                            deleteTodo(item.id_todo);
                        });
                        listItem.appendChild(editButton);
                        listItem.appendChild(deleteButton);
                        todoList.appendChild(listItem);
                    }
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

    function editTodoStatus(todoId, currentStatus, currentPriority) {
        const newStatus = prompt("Enter new status for the todo:", currentStatus);
        const newPriority = prompt("Enter new priority for the todo:", currentPriority);
        if (newStatus && newPriority) {
            const requestData = { action: 'edit_status', todoId, newStatus, newPriority };
            fetch('controllers/TodoPostController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const userId = localStorage.getItem('userId');
                    fetchTodos(userId);
                } else {
                    console.error('Error editing status:', data.error);
                }
            })
            .catch(error => console.error('Error editing status:', error));
        }
    }

    function deleteTodo(todoId) {
        const requestData = { action: 'delete_todo', todoId };
        fetch('controllers/TodoPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const userId = localStorage.getItem('userId');
                fetchTodos(userId);
            } else {
                console.error('Error deleting todo:', data.error);
            }
        })
        .catch(error => console.error('Error deleting todo:', error));
    }

    function restoreTodo(todoId) {
        const requestData = { action: 'restore_todo', todoId };
        fetch('controllers/TodoPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const userId = localStorage.getItem('userId');
                fetchTodos(userId);
            } else {
                console.error('Error restoring todo:', data.error);
            }
        })
        .catch(error => console.error('Error restoring todo:', error));
    }

    const storedUserId = localStorage.getItem('userId');
    const storedUserRole = localStorage.getItem('userRole');
    if (storedUserId) {
        showLogoutButton();
        fetchTodos(storedUserId);
        if (storedUserRole === 'admin') {
            showAdminPanel();
        }
    } else {
        showLoginForm();
    }
});
