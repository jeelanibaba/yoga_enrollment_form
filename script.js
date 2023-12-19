function submitForm() {
  const formData = {
    name: document.getElementById('name').value,
    email: document.getElementById('email').value,
    age: document.getElementById('age').value,
    batch: document.getElementById('batch').value,
  };

  if (!formData.name || !formData.email || !formData.age || !formData.batch) {
    document.getElementById('message').textContent = 'Please fill in all required fields.';
    return;
  }

  if (formData.age < 18 || formData.age > 65) {
    document.getElementById('message').textContent = 'Please enter a valid age between 18 and 65.';
    return;
  }

  fetch('backend.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(formData),
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        document.getElementById('message').textContent = 'Enrollment successful! ';
      }
       else {
        document.getElementById('message').textContent = "you have already registered";
      }
    })
    .catch(error => {
      document.getElementById('message').textContent = 'Something went wrong: ' + error;
    });
}


document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();
  submitForm();
});

