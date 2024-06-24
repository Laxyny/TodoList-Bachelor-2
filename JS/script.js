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
    const todoCategorie = document.getElementById('todoCategorie');

    const todoEditForm = document.getElementById('todoEditForm');
    const todoEditTitle = document.getElementById('todoEditTitle');
    const todoEditDescription = document.getElementById('todoEditDescription');
    const todoEditDueDate = document.getElementById('todoEditDueDate');
    const todoEditStatus = document.getElementById('todoEditStatus');
    const todoEditPriority = document.getElementById('todoEditPriority');
    const todoEditCategorie = document.getElementById('todoEditCategorie');
    const todoModificationList = document.getElementById('todoModificationList');
    const cancelEditButton = document.getElementById('cancelEditButton');

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

    const listCategoriesButton = document.getElementById('listCategoriesButton');
    const categoriesList = document.getElementById('categoriesList');
    const createCategoriesForm = document.getElementById('createCategoriesForm');
    const createCategorieName = document.getElementById('createCategorieName');

    const listDeletedTodosButton = document.getElementById('listDeletedTodosButton');
    const deletedTodoList = document.getElementById('deletedTodoList');

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

    function getUserId() {
        return sessionStorage.getItem('userId');
    }

    logoutButton.addEventListener('click', function () {
        localStorage.removeItem('userId');
        localStorage.removeItem('userRole');
        showLoginForm();
    });

    //Créer un todo
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
            console.error('Tout les champs doivent êtres remplis');
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

    //Afficher les utilisateurs (ADMIN)
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

//Affiche les differentes catégorties lors de la création d'un todo (todoCategorie)
    fetch('controllers/CategorieGetController.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id_categorie;
            option.textContent = item.libelle;
            todoCategorie.appendChild(option);
        });
    })

    listDeletedTodosButton.addEventListener('click', function () {
        fetch('controllers/TodoGetController.php?action=fetch_deleted')
        .then(response => response.json())
        .then(data => {
            deletedTodoList.innerHTML = '';
            data.forEach(item => {
                const listItem = document.createElement('div');
                listItem.innerHTML = `<strong>${item.titre}</strong>: ${item.description} (Créé le ${item.date_creation}, Échéance: ${item.date_echeance})<br>Status: ${item.libelle_statut}, Priority: ${item.libelle_priorite}, Categorie: ${item.libelle_categorie}`;
                const restoreButton = document.createElement('button');
                restoreButton.textContent = 'Restore';
                restoreButton.addEventListener('click', function () {
                    restoreTodoAdmin(item.id_todo);
                });
                listItem.appendChild(restoreButton);
                deletedTodoList.appendChild(listItem);
            });
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
            todoList.innerHTML = '';
            if (data.error) {
                const errorItem = document.createElement('div');
                errorItem.textContent = 'Error: ' + data.error;
                todoList.appendChild(errorItem);
            } else {
                data.forEach(item => {
                    if (item.id_statut != 4) {
                        const listItem = document.createElement('div');
                        listItem.innerHTML = `<strong>${item.titre}</strong>: ${item.description} (Créé le ${item.date_creation}, Échéance: ${item.date_echeance})<br>Status: ${item.libelle_statut}, Priority: ${item.libelle_priorite}, Categorie: ${item.libelle_categorie}`;
                        const editButton = document.createElement('button');
                        editButton.textContent = 'Edit';
                        editButton.addEventListener('click', function () {
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

    function editTodo(todoId, currentTitle, currentDescription, currentDueDate, currentStatus, currentPriority, currentCategorie) {
        todoEditTitle.value = currentTitle;
        todoEditDescription.value = currentDescription;
        todoEditDueDate.value = currentDueDate;
        todoEditStatus.value = currentStatus;
        todoEditPriority.value = currentPriority;
        todoEditCategorie.value = currentCategorie;

        todoEditForm.style.display = 'block';

        todoEditForm.addEventListener('submit', function (event) {
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
                } else {
                    console.error('Error editing todo:', data.error);
                }
            })
            .catch(error => console.error('Error editing todo:', error));
        });

        cancelEditButton.addEventListener('click', function () {
            todoEditForm.style.display = 'none';
        });
    }

    function RecupCategories() {
        fetch('controllers/CategorieGetController.php')
        .then(response => response.json())
        .then(data => {
            todoEditCategorie.innerHTML = ''; // Clear previous options
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id_categorie;
                option.textContent = item.libelle;
                todoEditCategorie.appendChild(option);
            });
        });
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
                listDeletedTodosButton.click();
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
