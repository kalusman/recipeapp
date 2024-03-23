document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addBtn');
    const modal = document.getElementById('overlay');
    const modalTitle = document.getElementById('modalTitle');
    const categoryName = document.getElementById('categoryName');
    const saveBtn = document.getElementById('saveBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const categoryList = document.getElementById('categoryList');

    let editingCategoryId = null;

    function showOverlay() {
        modal.style.display = 'block';
    }

    function hideOverlay() {
        modal.style.display = 'none';
        categoryName.value = '';
        editingCategoryId = null;
    }

    addBtn.addEventListener('click', function() {
        showOverlay();
        modalTitle.textContent = 'Add Category';
        saveBtn.textContent = 'Save';
    });

    saveBtn.addEventListener('click', function() {
        const name = categoryName.value.trim();

        if (name === '') {
            alert('Please enter a category name');
            return;
        }

        if (editingCategoryId) {
            // Update existing category
            fetch('updateCategory.php', {
                method: 'POST',
                body: JSON.stringify({ id: editingCategoryId, name }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Category updated successfully');
                    hideOverlay();
                    fetchCategories();
                } else {
                    alert('Failed to update category');
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            // Add new category
            fetch('addCategory.php', {
                method: 'POST',
                body: JSON.stringify({ name }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Category added successfully');
                    hideOverlay();
                    fetchCategories();
                } else {
                    alert('Failed to add category');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    deleteBtn.addEventListener('click', function() {
        if (!editingCategoryId) {
            return;
        }

        if (confirm('Are you sure you want to delete this category?')) {
            fetch('deleteCategory.php', {
                method: 'POST',
                body: JSON.stringify({ id: editingCategoryId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Category deleted successfully');
                    hideOverlay();
                    fetchCategories();
                } else {
                    alert('Failed to delete category');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    function fetchCategories() {
        fetch('getCategories.php')
        .then(response => response.json())
        .then(data => {
            let html = '';
            data.forEach(category => {
                html += `<tr>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>
                                <button onclick="editCategory(${category.id}, '${category.name}')">Edit</button>
                                <button onclick="deleteCategory(${category.id})">Delete</button>
                            </td>
                        </tr>`;
            });
            categoryList.innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
    }

    function editCategory(id, name) {
        editingCategoryId = id;
        categoryName.value = name;
        showOverlay();
        modalTitle.textContent = 'Edit Category';
        saveBtn.textContent = 'Update';
    }

    function deleteCategory(id) {
        editingCategoryId = id;
        showOverlay();
        modalTitle.textContent = 'Delete Category';
        categoryName.value = '';
        saveBtn.style.display = 'none';
        deleteBtn.style.display = 'inline-block';
    }

    document.querySelector('.close').addEventListener('click', hideOverlay);

    fetchCategories();
});
