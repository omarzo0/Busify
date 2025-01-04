/*const form = document.getElementById("form");

form.addEventListener('submit', (e) => {
    e.preventDefault();
    validateInputs();
});

const setError = (element, message) => {
    const inputField = element.parentElement;
    const errorDisplay = inputField.querySelector('.error');

    errorDisplay.textContent = message;
    inputField.classList.add('error');
    inputField.classList.remove('success');
};

const setSuccess = (element) => {
    const inputField = element.parentElement;

    inputField.querySelector('.error').innerText = '';
    inputField.classList.remove('error');
    inputField.classList.add('success');
};

const isValidEmail = (email) => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};

const isValidPassword = (password) => {
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return re.test(String(password));
};

const validateInputs = () => {
    const inputs = document.querySelectorAll('.input__fields input');

    let isValidForm = true;

    inputs.forEach((input) => {
        const value = input.value.trim();
        const id = input.id;
        const label = input.parentElement.querySelector('label');

        if (value === '') {
            setError(input, `${label.textContent} cannot be blank`);
            isValidForm = false;
        } else {
            setSuccess(input);
        }
    });

    const email = document.getElementById('email');
    const emailValue = email.value.trim();

    if (!isValidEmail(emailValue)) {
        setError(email, 'Email is not valid');
        isValidForm = false;
    }

    const password = document.getElementById('password');
    const passwordValue = password.value.trim();

    if (!isValidPassword(passwordValue)) {
        setError(password, 'Password must contain at least 8 characters,\n one uppercase, one lowercase, one number and one special character');
        isValidForm = false;
    }

    const cpassword = document.getElementById('cpassword');
    const cpasswordValue = cpassword.value.trim();

    if (passwordValue !== cpasswordValue) {
        setError(cpassword, 'Passwords do not match');
        isValidForm = false;
    }
};
*/ // Fetch Data from API
async function fetchData(url) {
  const response = await fetch(url);
  return response.json();
}

// Update Metrics
async function updateDashboard() {
  const busesData = await fetchData("/api/total-buses");
  const driversData = await fetchData("/api/total-drivers");
  const passengersData = await fetchData("/api/total-passengers");

  document.getElementById("total-buses").innerText = busesData.total;
  document.getElementById("total-drivers").innerText = driversData.total;
  document.getElementById("total-passengers").innerText = passengersData.total;
}

// Render Charts
function renderCharts() {
  const revenueChart = new Chart(
    document.getElementById("revenueChart").getContext("2d"),
    {
      type: "bar",
      data: {
        labels: ["Trip 1", "Trip 2", "Trip 3"],
        datasets: [
          {
            label: "Revenue",
            data: [100, 200, 300],
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
          },
        ],
      },
    }
  );

  const registrationsChart = new Chart(
    document.getElementById("registrationsChart").getContext("2d"),
    {
      type: "line",
      data: {
        labels: ["Day 1", "Day 2", "Day 3"],
        datasets: [
          {
            label: "Registrations",
            data: [5, 15, 20],
            backgroundColor: "rgba(153, 102, 255, 0.2)",
            borderColor: "rgba(153, 102, 255, 1)",
            borderWidth: 1,
          },
        ],
      },
    }
  );
}

// Initialize Dashboard
document.addEventListener("DOMContentLoaded", () => {
  updateDashboard();
  renderCharts();
});
