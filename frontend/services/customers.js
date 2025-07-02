var CustomersService = {
    // Get all customers
    getCustomers: function() {
        return fetch('/customers')
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching customers:', error);
                return [];
            });
    },

    // Get meals for a specific customer
    getCustomerMeals: function(customerId) {
        return fetch(`/customer/meals/${customerId}`)
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching customer meals:', error);
                return [];
            });
    },

    // Add a new customer
    addCustomer: function(customerData) {
        return fetch('/customers/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(customerData)
        })
        .then(response => response.json())
        .catch(error => {
            console.error('Error adding customer:', error);
            return null;
        });
    }
}