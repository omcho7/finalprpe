var FoodsService = {
    // Get foods report with all nutrients
    getFoodsReport: function() {
        return fetch('/foods/report')
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching foods report:', error);
                return [];
            });
    },

    // Populate foods table with data from API
    populateFoodsTable: function() {
        this.getFoodsReport().then(foods => {
            const tbody = document.querySelector('.table tbody');
            if (tbody) {
                tbody.innerHTML = '';
                
                foods.forEach(food => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${food.name}</td>
                        <td>${food.brand}</td>
                        <td class="text-center">${food.image}</td>
                        <td>${food.energy || 0}</td>
                        <td>${food.protein || 0}</td>
                        <td>${food.fat || 0}</td>
                        <td>${food.fiber || 0}</td>
                        <td>${food.carbs || 0}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        });
    }
}