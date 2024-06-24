document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;

    // Conteneur principal pour centrer les éléments
    const mainContainer = document.createElement('div');
    mainContainer.classList.add('container');
    body.appendChild(mainContainer);

    const logoutContainer = document.createElement('div');
    logoutContainer.classList.add('logout-container');
    mainContainer.appendChild(logoutContainer);

    const todoList = document.createElement('div');
    todoList.id = 'todo-list';
    mainContainer.appendChild(todoList);

    const loginForm = document.createElement('form');
    loginForm.id = 'loginForm';
    loginForm.innerHTML = `
        <input type="text" id="loginUtilisateur" placeholder="Utilisateur">
        <input type="password" id="loginPassword" placeholder="Password">
        <button type="submit">Login</button>
        <div id="loginError"></div>
    `;
    mainContainer.appendChild(loginForm);

    const registerForm = document.createElement('form');
    registerForm.id = 'registerForm';
    registerForm.innerHTML = `
        <input type="text" id="registerUtilisateur" placeholder="Utilisateur">
        <input type="password" id="registerPassword" placeholder="Password">
        <button type="submit">Register</button>
        <div id="registerError"></div>
    `;
    mainContainer.appendChild(registerForm);

    const logoutButton = document.createElement('button');
    logoutButton.id = 'logoutButton';
    logoutButton.style.display = 'none';
    logoutButton.textContent = 'Logout';
    logoutContainer.appendChild(logoutButton);

    const todoForm = document.createElement('form');
    todoForm.id = 'todoForm';
    todoForm.style.display = 'none';
    todoForm.innerHTML = `
        <input type="text" id="todoTitle" placeholder="Title">
        <input type="text" id="todoDescription" placeholder="Description">
        <input type="date" id="todoDueDate" placeholder="Due Date">
        <select id="todoStatus">
            <option value="1">Créé</option>
            <option value="2">En cours</option>
            <option value="3">Effectué</option>
        </select>
        <select id="todoPriority">
            <option value="1">Basse</option>
            <option value="2">Normale</option>
            <option value="3">Haute</option>
        </select>
        <select id="todoCategorie"></select>
        <button type="submit">Add Todo</button>
    `;
    mainContainer.appendChild(todoForm);

    const todoEditForm = document.createElement('form');
    todoEditForm.id = 'todoEditForm';
    todoEditForm.style.display = 'none';
    todoEditForm.innerHTML = `
        <input type="text" id="todoEditTitle" placeholder="Title">
        <input type="text" id="todoEditDescription" placeholder="Description">
        <input type="date" id="todoEditDueDate" placeholder="Due Date">
        <select id="todoEditStatus">
            <option value="1">Créé</option>
            <option value="2">En cours</option>
            <option value="3">Effectué</option>
        </select>
        <select id="todoEditPriority">
            <option value="1">Basse</option>
            <option value="2">Normale</option>
            <option value="3">Haute</option>
        </select>
        <select id="todoEditCategorie"></select>
        <button type="submit">Save Changes</button>
        <button type="button" id="cancelEditButton">Cancel</button>
    `;
    mainContainer.appendChild(todoEditForm);

    const adminPanel = document.createElement('div');
    adminPanel.id = 'adminPanel';
    adminPanel.style.display = 'none';
    
    const toggleAdminButton = document.createElement('button');
    toggleAdminButton.id = 'toggleAdminButton';
    toggleAdminButton.textContent = 'Afficher le menu Admin';
    mainContainer.appendChild(adminPanel);
    mainContainer.appendChild(toggleAdminButton);

    const adminSectionContainer = document.createElement('div');
    adminSectionContainer.classList.add('admin-section-container');
    adminPanel.appendChild(adminSectionContainer);

    const userManagement = document.createElement('div');
    userManagement.classList.add('admin-section');
    userManagement.innerHTML = `
        <h3>Manage Users</h3>
        <button id="listUsersButton">List Users</button>
        <div id="userList"></div>
        <h4>Create User</h4>
        <form id="createUserForm">
            <input type="text" id="createUserUtilisateur" placeholder="Utilisateur" required>
            <input type="password" id="createUserPassword" placeholder="Password" required>
            <select id="createUserRole">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Create User</button>
        </form>
    `;
    adminSectionContainer.appendChild(userManagement);

    const statusManagement = document.createElement('div');
    statusManagement.classList.add('admin-section');
    statusManagement.innerHTML = `
        <h3>Manage Statuses</h3>
        <button id="listStatusesButton">List Statuses</button>
        <div id="statusList"></div>
        <h4>Create Status</h4>
        <form id="createStatusForm">
            <input type="text" id="createStatusName" placeholder="Status Name">
            <button type="submit">Create Status</button>
        </form>
    `;
    adminSectionContainer.appendChild(statusManagement);

    const categoriesManagement = document.createElement('div');
    categoriesManagement.classList.add('admin-section');
    categoriesManagement.innerHTML = `
        <h3>Manage Categories</h3>
        <button id="listCategoriesButton">List Categories</button>
        <div id="categoriesList"></div>
        <h4>Create Categorie</h4>
        <form id="createCategoriesForm">
            <input type="text" id="createCategorieName" placeholder="Categorie Name">
            <button type="submit">Create Categorie</button>
        </form>
    `;
    adminSectionContainer.appendChild(categoriesManagement);

    const deletedTodosManagement = document.createElement('div');
    deletedTodosManagement.classList.add('admin-section');
    deletedTodosManagement.innerHTML = `
        <h3>Manage Deleted Todos</h3>
        <button id="listDeletedTodosButton">List Deleted Todos</button>
        <div id="deletedTodoList"></div>
    `;
    adminSectionContainer.appendChild(deletedTodosManagement);

    // Ajout de l'événement pour basculer la visibilité du panneau admin
    toggleAdminButton.addEventListener('click', function () {
        if (adminPanel.style.display === 'none') {
            adminPanel.style.display = 'block';
        } else {
            adminPanel.style.display = 'none';
        }
    });

    // Références aux éléments dynamiques
    const loginError = document.getElementById('loginError');
    const registerError = document.getElementById('registerError');
    const todoTitle = document.getElementById('todoTitle');
    const todoDescription = document.getElementById('todoDescription');
    const todoDueDate = document.getElementById('todoDueDate');
    const todoStatus = document.getElementById('todoStatus');
    const todoPriority = document.getElementById('todoPriority');
    const todoCategorie = document.getElementById('todoCategorie');
    const todoEditTitle = document.getElementById('todoEditTitle');
    const todoEditDescription = document.getElementById('todoEditDescription');
    const todoEditDueDate = document.getElementById('todoEditDueDate');
    const todoEditStatus = document.getElementById('todoEditStatus');
    const todoEditPriority = document.getElementById('todoEditPriority');
    const todoEditCategorie = document.getElementById('todoEditCategorie');
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
    const listCategoriesButton = document.getElementById('listCategoriesButton');
    const categoriesList = document.getElementById('categoriesList');
    const createCategoriesForm = document.getElementById('createCategoriesForm');
    const createCategorieName = document.getElementById('createCategorieName');
    const listDeletedTodosButton = document.getElementById('listDeletedTodosButton');
    const deletedTodoList = document.getElementById('deletedTodoList');
    const cancelEditButton = document.getElementById('cancelEditButton');

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

    function getUserId() {
        return sessionStorage.getItem('userId');
    }

    logoutButton.addEventListener('click', function () {
        localStorage.removeItem('userId');
        localStorage.removeItem('userRole');
        showLoginForm();
    });

    // Créer un todo
    todoForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const titre = todoTitle.value;
        const description = todoDescription.value;
        const date_echeance = todoDueDate.value;
        const id_statut = todoStatus.value;
        const id_priorite = todoPriority.value;
        const id_categorie = todoCategorie.value;
        const id_utilisateur = localStorage.getItem('userId');

        const date_creation = new Date().toISOString().split('T')[0];

        if (!titre || !description || !date_echeance || !id_statut || !id_priorite || !id_utilisateur) {
            console.error('Tous les champs doivent être remplis');
            return;
        }

        const requestData = { action: 'create_todo', titre, description, date_creation, date_echeance, id_statut, id_priorite, id_categorie, id_utilisateur };
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
                const userId = localStorage.getItem('userId');
                fetchTodos(userId);
                todoTitle.value = '';
                todoDescription.value = '';
                todoDueDate.value = '';
                todoStatus.value = '';
                todoPriority.value = '';
                todoCategorie.value = '';
            } else {
                console.error('Error adding todo:', data.error);
            }
        })
        .catch(error => {
            console.error('Error adding todo:', error);
        });
    });

    // Afficher les utilisateurs (ADMIN)
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
            console.log('Data received from API for users:', data); // Log the received data
            userList.innerHTML = '';
            if (!Array.isArray(data)) {
                console.error('Error: Expected an array but received:', data);
                return;
            }
            data.forEach(user => {
                const userItem = document.createElement('div');
                userItem.textContent = `${user.utilisateur} ${user.mot_de_passe} (${user.role})`;

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Supprimer';
                deleteButton.addEventListener('click', function () {
                    deleteUserAdmin(user.id_utilisateur);
                });
                userItem.appendChild(deleteButton);
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
        .then(response => response.text())
        .then(text => {
            console.log('Raw response from API:', text);
            try {
                const data = JSON.parse(text);
                console.log('Parsed JSON data:', data);
                if (data.success) {
                    console.log('User created successfully');
                    // Optionally refresh the user list
                    listUsersButton.click();
                } else {
                    console.error('Error creating user:', data.error);
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        })
        .catch(error => console.error('Error creating user:', error));
    });

    listStatusesButton.addEventListener('click', function () {
        fetch('controllers/AdminController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'list_status' })
        })
        .then(response => response.json())
        .then(data => {
            statusList.innerHTML = '';
            data.forEach(status => {
                const statusItem = document.createElement('div');
                statusItem.textContent = `${status.id_statut} - ${status.libelle}`;
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

    // Bouton et champs de texte pour les catégories
    listCategoriesButton.addEventListener('click', function () {
        fetch('controllers/AdminController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'list_categories' })
        })
        .then(response => response.json())
        .then(data => {
            categoriesList.innerHTML = '';
            data.forEach(categories => {
                const categoriesItem = document.createElement('div');
                categoriesItem.textContent = `${categories.id_categorie} - ${categories.libelle}`;

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Supprimer';
                deleteButton.addEventListener('click', function () {
                    deleteCategorieAdmin(categories.id_categorie);
                });
                categoriesItem.appendChild(deleteButton);
                categoriesList.appendChild(categoriesItem);
            });
        })
        .catch(error => console.error('Error listing categories:', error));
    });

    createCategoriesForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = createCategorieName.value;

        const requestData = { action: 'create_categorie', name };
        fetch('controllers/CategoriePostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createCategorieName.value = '';
                listCategoriesButton.click();
            } else {
                console.error('Error creating categorie:', data.error);
            }
        })
        .catch(error => console.error('Error creating categories:', error));
    });

    // Affiche les différentes catégories lors de la création d'un todo (todoCategorie)
    function RecupCategories() {
        fetch('controllers/CategorieGetController.php')
        .then(response => response.json())
        .then(data => {
            todoCategorie.innerHTML = ''; // Clear previous options
            todoEditCategorie.innerHTML = ''; // Clear previous options
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id_categorie;
                option.textContent = item.libelle;
                todoCategorie.appendChild(option.cloneNode(true)); // Append to todoCategorie
                todoEditCategorie.appendChild(option); // Append to todoEditCategorie
            });
        });
    }

    listDeletedTodosButton.addEventListener('click', function () {
        fetch('controllers/TodoGetController.php?action=fetch_deleted')
        .then(response => response.json())
        .then(data => {
            deletedTodoList.innerHTML = ''; // Clear the list
            const table = document.createElement('table');
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            `;
            const tbody = table.querySelector('tbody');
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.titre}</td>
                    <td>${item.description}</td>
                    <td>${item.date_creation}</td>
                    <td>${item.date_echeance}</td>
                    <td>${item.libelle_statut}</td>
                    <td>${item.libelle_priorite}</td>
                    <td>${item.libelle_categorie}</td>
                    <td>
                        <button class="restore-button">Restore</button>
                    </td>
                `;
                row.querySelector('.restore-button').addEventListener('click', function () {
                    restoreTodoAdmin(item.id_todo);
                });
                tbody.appendChild(row);
            });
            deletedTodoList.appendChild(table);
        })
        .catch(error => console.error('Error listing deleted todos:', error));
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
            todoList.innerHTML = ''; // Clear the list
            if (data.error) {
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Error: ' + data.error;
                todoList.appendChild(errorItem);
            } else {
                const table = document.createElement('table');
                table.innerHTML = `
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `;
                const tbody = table.querySelector('tbody');
                data.forEach(item => {
                    if (item.id_statut != 4) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.titre}</td>
                            <td>${item.description}</td>
                            <td>${item.date_creation}</td>
                            <td>${item.date_echeance}</td>
                            <td>${item.libelle_statut}</td>
                            <td>${item.libelle_priorite}</td>
                            <td>${item.libelle_categorie}</td>
                            <td>
                                <button class="edit-button">Edit</button>
                                <button class="delete-button">Delete</button>
                            </td>
                        `;
                        row.querySelector('.edit-button').addEventListener('click', function () {
                            editTodo(
                                item.id_todo,
                                item.titre,
                                item.description,
                                item.date_echeance,
                                item.id_statut,
                                item.id_priorite,
                                item.id_categorie
                            );
                        });
                        row.querySelector('.delete-button').addEventListener('click', function () {
                            deleteTodo(item.id_todo);
                        });
                        tbody.appendChild(row);
                    }
                });
                todoList.appendChild(table);
            }
        })
        .catch(error => {
            console.error('Error fetching todo list:', error);
            const errorItem = document.createElement('div');
            errorItem.textContent = 'Error: ' + error.message;
            todoList.appendChild(errorItem);
        });
    }

    function editTodo(todoId, currentTitle, currentDescription, currentDueDate, currentStatus, currentPriority, currentCategorie) {
        todoEditTitle.value = currentTitle;
        todoEditDescription.value = currentDescription;
        todoEditDueDate.value = currentDueDate;
        todoEditStatus.value = currentStatus;
        todoEditPriority.value = currentPriority;
        todoEditCategorie.value = currentCategorie;

        todoEditForm.style.display = 'block';
        todoForm.style.display = 'none';

        todoEditForm.onsubmit = function (event) {
            event.preventDefault();

            const newTitle = todoEditTitle.value;
            const newDescription = todoEditDescription.value;
            const newDueDate = todoEditDueDate.value;
            const newStatus = todoEditStatus.value;
            const newPriority = todoEditPriority.value;
            const newCategorie = todoEditCategorie.value;

            const requestData = { action: 'edit_todo', todoId, newTitle, newDescription, newDueDate, newStatus, newPriority, newCategorie };

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
                    todoEditForm.style.display = 'none';
                    todoForm.style.display = 'block';
                } else {
                    console.error('Error editing todo:', data.error);
                }
            })
            .catch(error => console.error('Error editing todo:', error));
        };

        cancelEditButton.onclick = function () {
            todoEditForm.style.display = 'none';
            todoForm.style.display = 'block';
        };
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

    function restoreTodoAdmin(todoId) {
        const requestData = { action: 'restore_todo_admin', todoId };
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
                fetchTodos(userId); // Refresh the active todos list
                listDeletedTodosButton.click(); // Refresh the deleted todos list
            } else {
                console.error('Error restoring todo:', data.error);
            }
        })
        .catch(error => console.error('Error restoring todo:', error));
    }

    function deleteCategorieAdmin(categorieId) {
        const requestData = { action: 'delete_categorie_admin', categorieId };
        fetch('controllers/CategoriePostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                listCategoriesButton.click();
            } else {
                console.error('Erreur lors de la suppression de la catégorie: ', data.error);
            }
        })
        .catch(error => console.error('Erreur lors de la suppression de la catégorie: ', error));
    }

    function deleteUserAdmin(userId) {
        const requestData = { action: 'delete_user_admin', userId };
        fetch('controllers/UtilisateurPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                listUsersButton.click();
            } else {
                console.error('Erreur lors de la suppression de l\'utilisateur: ', data.error);
            }
        })
        .catch(error => console.error('Erreur lors de la suppression de l\'utilisateur: ', error));
    }

    RecupCategories();
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
