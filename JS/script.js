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

    const RegisterForm = document.createElement('form');
    RegisterForm.id = 'registerForm';
    RegisterForm.innerHTML = `
        <input type="text" id="RegisterUtilisateur" placeholder="Utilisateur">
        <input type="email" id="RegisterEmail" placeholder="Email">
        <input type="password" id="RegisterPassword" placeholder="Mot de passe">
        <select id="userGender">
            <option value="1">Homme</option>
            <option value="2">Femme</option>
        </select>
        <input type="date" id="RegisterBirthdate" placeholder="Date de naissance">
        <input type="text" id="RegisterLocation" placeholder="Votre ville (Facultatif)">
        <button type="submit">Créer un compte</button>
        <div id="loginError"></div>
    `;
    mainContainer.appendChild(RegisterForm);

    const loginForm = document.createElement('form');
    loginForm.id = 'loginForm';
    loginForm.innerHTML = `
        <input type="text" id="loginUtilisateur" placeholder="Utilisateur">
        <input type="password" id="loginPassword" placeholder="Mot de passe">
        <button type="submit">Connexion</button>
        <div id="loginError"></div>
    `;
    mainContainer.appendChild(loginForm);

    const logoutButton = document.createElement('button');
    logoutButton.id = 'logoutButton';
    logoutButton.style.display = 'none';
    logoutButton.textContent = 'Deconnexion';
    logoutContainer.appendChild(logoutButton);

    const todoForm = document.createElement('form');
    todoForm.id = 'todoForm';
    todoForm.style.display = 'none';
    todoForm.innerHTML = `
        <input type="text" id="todoTitle" placeholder="Titre">
        <input type="text" id="todoDescription" placeholder="Description">
        <input type="date" id="todoDueDate" placeholder="Date échéance">
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
        <button type="submit">Créer le Todo</button>
    `;
    mainContainer.appendChild(todoForm);

    const todoEditForm = document.createElement('form');
    todoEditForm.id = 'todoEditForm';
    todoEditForm.style.display = 'none';
    todoEditForm.innerHTML = `
        <input type="text" id="todoEditTitle" placeholder="Titre">
        <input type="text" id="todoEditDescription" placeholder="Description">
        <input type="date" id="todoEditDueDate" placeholder="Date échéance">
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
        <button type="submit">Sauvegarder</button>
        <button type="button" id="cancelEditButton">Annuler</button>
    `;
    mainContainer.appendChild(todoEditForm);

    const modificationsSection = document.createElement('div');
    modificationsSection.id = 'modifications';
    modificationsSection.innerHTML = `
        <h3>Modification(s)</h3>
        <ul id="modifications-list"></ul>
    `;
    todoEditForm.appendChild(modificationsSection);

    const adminPanel = document.createElement('div');
    adminPanel.id = 'adminPanel';
    adminPanel.style.display = 'none';
    mainContainer.appendChild(adminPanel);

    const adminSectionContainer = document.createElement('div');
    adminSectionContainer.classList.add('admin-section-container');
    adminPanel.appendChild(adminSectionContainer);

    const userManagement = document.createElement('div');
    userManagement.classList.add('admin-section');
    userManagement.innerHTML = `
        <h3>Gérer les Utilisateurs</h3>
        <button id="listUsersButton">Afficher les utilisateurs</button>
        <div id="userList"></div>
        <h4>ajouter l'utilisateur</h4>
        <form id="createUserForm">
            <input type="text" id="createUserUtilisateur" placeholder="Utilisateur" required>
            <input type="password" id="createUserPassword" placeholder="Mot de passe" required>
            <select id="createUserRole">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Ajouter l'utilisateur</button>
        </form>
    `;
    adminSectionContainer.appendChild(userManagement);

    const categoriesManagement = document.createElement('div');
    categoriesManagement.classList.add('admin-section');
    categoriesManagement.innerHTML = `
        <h3>Gérer les Categories</h3>
        <button id="listCategoriesButton">Afficher les Categories</button>
        <div id="categoriesList"></div>
        <h4>Créer une Categorie</h4>
        <form id="createCategoriesForm">
            <input type="text" id="createCategorieName" placeholder="Nom de la Categorie">
            <button type="submit">Créer la Categorie</button>
        </form>
    `;
    adminSectionContainer.appendChild(categoriesManagement);

    const deletedTodosManagement = document.createElement('div');
    deletedTodosManagement.classList.add('admin-section');
    deletedTodosManagement.innerHTML = `
        <h3>Gérer les Todos supprimés</h3>
        <button id="listDeletedTodosButton">Afficher les Todos supprimés</button>
        <div id="deletedTodoList"></div>
    `;
    adminSectionContainer.appendChild(deletedTodosManagement);

    const loginError = document.getElementById('loginError');
    const todoTitle = document.getElementById('todoTitle');
    const todoDescription = document.getElementById('todoDescription');
    const todoDueDate = document.getElementById('todoDueDate');
    const todoStatus = document.getElementById('todoStatus');
    const todoPriority = document.getElementById('todoPriority');
    const todoCategorie = document.getElementById('todoCategorie');
    const todoEditId = document.getElementById('todoEditId');
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
    const listCategoriesButton = document.getElementById('listCategoriesButton');
    const categoriesList = document.getElementById('categoriesList');
    const createCategoriesForm = document.getElementById('createCategoriesForm');
    const createCategorieName = document.getElementById('createCategorieName');
    const listDeletedTodosButton = document.getElementById('listDeletedTodosButton');
    const deletedTodoList = document.getElementById('deletedTodoList');
    const cancelEditButton = document.getElementById('cancelEditButton');

    function showRegisterForm() {
        RegisterForm.style.display = 'block';
        logoutButton.style.display = 'none';
        todoForm.style.display = 'none';
        adminPanel.style.display = 'none';
        todoList.innerHTML = '';
    }

    function showLoginForm() {
        loginForm.style.display = 'block';
        logoutButton.style.display = 'none';
        todoForm.style.display = 'none';
        adminPanel.style.display = 'none';
        todoList.innerHTML = '';
    }

    function showLogoutButton() {
        loginForm.style.display = 'none';
        logoutButton.style.display = 'block';
        todoForm.style.display = 'block';
    }

    function showAdminPanel() {
        adminPanel.style.display = 'block';
    }

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const utilisateur = document.getElementById('loginUtilisateur').value;
        const password = document.getElementById('loginPassword').value;

        const requestData = { utilisateur, password };

        fetch('controllers/LoginPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
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
                console.error('Erreur lors de la connexion:', error);
                loginError.textContent = 'Erreur réseau';
            });
    });

    function getUserId() {
        return sessionStorage.getItem('userId');
    }

    logoutButton.addEventListener('click', function () {
        localStorage.removeItem('userId');
        localStorage.removeItem('userRole');
        showRegisterForm();
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
        console.log('Données du todo:', requestData);

        fetch('controllers/TodoPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
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
                    console.error('Erreur ajout Todo:', data.error);
                }
            })
            .catch(error => {
                console.error('Erreur ajout Todo:', error);
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
                userList.innerHTML = '';
                if (!Array.isArray(data)) {
                    console.error('Erreur des datas:', data);
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
            .catch(error => console.error('Erreur affichage Utilisateurs:', error));
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
                try {
                    const data = JSON.parse(text);
                    console.log('Parsed JSON data:', data);
                    if (data.success) {
                        console.log('Utilisateur créé');
                        listUsersButton.click();
                    } else {
                        console.error('Erreur création Utilisateur:', data.error);
                    }
                } catch (e) {
                    console.error('Erreur parsing JSON:', e);
                }
            })
            .catch(error => console.error('Erreur creation Utilisateur:', error));
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
            .catch(error => console.error('Error affichage Categories:', error));
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
                    console.error('Erreur creation Categorie:', data.error);
                }
            })
            .catch(error => console.error('Erreur creation Categorie:', error));
    });

    // Affiche les différentes catégories lors de la création d'un todo (todoCategorie)
    function RecupCategories() {
        fetch('controllers/CategorieGetController.php')
            .then(response => response.json())
            .then(data => {
                todoCategorie.innerHTML = '';
                todoEditCategorie.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id_categorie;
                    option.textContent = item.libelle;
                    todoCategorie.appendChild(option.cloneNode(true));
                    todoEditCategorie.appendChild(option);
                });
            });
    }

    listDeletedTodosButton.addEventListener('click', function () {
        fetch('controllers/TodoGetController.php?action=fetch_deleted')
            .then(response => response.json())
            .then(data => {
                deletedTodoList.innerHTML = '';
                const table = document.createElement('table');
                table.innerHTML = `
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date création</th>
                        <th>Date échéance</th>
                        <th>Status</th>
                        <th>Priorité</th>
                        <th>Categorie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            `;
                const tbody = table.querySelector('tbody');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${item.libelle_utilisateur}</td>
                    <td>${item.titre}</td>
                    <td>${item.description}</td>
                    <td>${item.date_creation}</td>
                    <td>${item.date_echeance}</td>
                    <td>${item.libelle_statut}</td>
                    <td>${item.libelle_priorite}</td>
                    <td>${item.libelle_categorie}</td>
                    <td>
                        <button class="restore-button">Restaurer</button>
                    </td>
                `;
                    row.querySelector('.restore-button').addEventListener('click', function () {
                        restoreTodoAdmin(item.id_todo);
                    });
                    tbody.appendChild(row);
                });
                deletedTodoList.appendChild(table);
            })
            .catch(error => console.error('Erreur affichage Todo supprimés:', error));
    });

    function fetchTodos(userId) {
        fetch(`controllers/TodoGetController.php?userId=${userId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                todoList.innerHTML = '';
                if (data.error) {
                    const errorItem = document.createElement('div');
                    errorItem.textContent = 'Error: ' + data.error;
                    todoList.appendChild(errorItem);
                } else {
                    const table = document.createElement('table');
                    table.innerHTML = `
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date création</th>
                            <th>Date échéance</th>
                            <th>Status</th>
                            <th>Priorité</th>
                            <th>Categorie</th>
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
                                <button class="edit-button">Editer</button>
                                <button class="delete-button">Supprimer</button>
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
                console.error('Erreur affichage Todo list:', error);
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Erreur: ' + error.message;
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

        fetch(`controllers/ModificationGetController.php?action=fetch_modifications&todoId=${todoId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error('Erreur ' + typeof data);
                }
                const modificationsList = document.getElementById('modifications-list');
                modificationsList.innerHTML = '';
                data.forEach(modifications => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${modifications.date_modification}: ${modifications.raison_modification}`;
                    modificationsList.appendChild(listItem);
                });
            })
            .catch(error => console.error('Erreur affichage Modifications:', error));

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

                        //Demander la raison de la modif
                        const raison = prompt('Veuillez indiquer la raison de la modification')
                        addRaisonModif(todoId, raison);
                    } else {
                        console.error('Erreur lors de l\'edit du Todo:', data.error);
                    }
                })
                .catch(error => console.error('Erreur lors de l\'edit du Todo:', error));
        };

        cancelEditButton.onclick = function () {
            todoEditForm.style.display = 'none';
            todoForm.style.display = 'block';
        };
    }

    function addRaisonModif(todoId, raison) {
        const requestDataRaisonModif = { action: 'raison_modif', raison, todoId };

        fetch('controllers/ModificationPostController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestDataRaisonModif)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const userId = localStorage.getItem('userId');
                    fetchTodos(userId);
                } else {
                    console.error('Erreur lors de add modif:', data.error);
                }
            })
            .catch(error => console.error('Erreur lors de add modif:', error));
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
                    console.error('Erreur suppression Todo:', data.error);
                }
            })
            .catch(error => console.error('Erreur suppression Todo:', error));
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
                    fetchTodos(userId);
                    listDeletedTodosButton.click();
                } else {
                    console.error('Erreur lors de la restauration du Todo:', data.error);
                }
            })
            .catch(error => console.error('Erreur lors de la restauration du Todo:', error));
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
                    console.error('Erreur lors de la suppression de la Catégorie: ', data.error);
                }
            })
            .catch(error => console.error('Erreur lors de la suppression de la Catégorie: ', error));
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
