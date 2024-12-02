document.addEventListener("DOMContentLoaded", function() {
    const searchButton = document.getElementById("searchButton");
    const countryInput = document.getElementById("countryInput");
    const resultDiv = document.getElementById("result");

    searchButton.addEventListener("click", function() {
        const country = countryInput.value;

        if (!country) {
            alert("Please enter a country name.");
            return;
        }

        // Make a request to the PHP script (world.php)
        fetch(`world.php?country=${encodeURIComponent(country)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    resultDiv.innerHTML = `Error: ${data.error}`;
                } else {
                    resultDiv.innerHTML = `<h3>Country: ${data.name}</h3>
                                           <p>Capital: ${data.capital}</p>
                                           <p>Region: ${data.region}</p>
                                           <p>Head of State: ${data.head_of_state}</p>`;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `Error: ${error.message}`;
            });
    });
});

