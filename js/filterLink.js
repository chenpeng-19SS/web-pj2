function changeSelect() {
    const filterByCountry = document.getElementById("filterByCountry");
    let filterByCity = document.getElementById("filterByCity");
    for (let i=0;i < filterByCity.options.length;i++){
        filterByCity.options[i].hidden = true;
    }
    let cities = document.getElementsByName(filterByCountry.value);
    for (let j=0;j<cities.length;j++){
        cities[j].hidden = false;
    }
}

