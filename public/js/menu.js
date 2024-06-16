function editDish(id) {
    fetch(`<?= base_url('/menu/getDish/') ?>${id}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('editDishId').value = id;
        document.getElementById('editDishName').value = data.name;
        document.getElementById('editDishPrice').value = data.price;
        document.getElementById('editDishDescription').value = data.description;

        document.getElementById('editDishForm').action = `<?= base_url('/menu/updateDish/') ?>${id}`;

        var editModal = new bootstrap.Modal(document.getElementById('editDishModal'));
        editModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
}



function confirmDelete(dishId) {
    if (confirm("Are you sure you want to delete this dish?")) {
        fetch(`<?= base_url('/menu/deleteDish/') ?>${dishId}`, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            // CSRF token 需要如果你的CI设置启用了CSRF保护
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok.');
        })
        .then(() => {
            // 成功后从DOM中移除菜品
            document.getElementById(`dish-${dishId}`).remove();
            alert('Dish deleted successfully.');
        })
        .catch(error => console.error('Error:', error));
    }
}



    function confirmDelete(dishId) {
    if (confirm("Are you sure you want to delete this dish?")) {
        fetch(`<?= base_url('/menu/deleteDish/') ?>${dishId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                // 如果你的应用启用了CSRF保护，确保添加CSRF token
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok.');
        })
        .then(() => {
            // 刷新页面以显示更新后的数据
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

