document.addEventListener("DOMContentLoaded", function() {
    const searchButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookupCities");
    const countryInput = document.getElementById("country");
    const resultDiv = document.getElementById("result");

    searchButton.addEventListener("click", function() {
        const country = countryInput.value;

        if (!country) {
            alert("Please enter a country name.");
            return;
        }

        fetch(`world.php?country=${country}`)
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

    lookupCitiesButton.addEventListener("click", function() {
        const country = countryInput.value;

        if (!country) {
            alert("Please enter a country name.");
            return;
        }

        // Make a request to the PHP script for city data
        fetch(`world.php?country=${country}&lookup=cities`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    resultDiv.innerHTML = `Error: ${data.error}`;
                } else {
                    let tableHTML = "<table><thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead><tbody>";
                    data.cities.forEach(city => {
                        tableHTML += `<tr><td>${city.name}</td><td>${city.district}</td><td>${city.population}</td></tr>`;
                    });
                    tableHTML += "</tbody></table>";
                    resultDiv.innerHTML = tableHTML;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `Error: ${error.message}`;
            });
    });
});

