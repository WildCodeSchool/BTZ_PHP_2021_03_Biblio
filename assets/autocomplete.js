document.getElementById('searchField').addEventListener('input', function(event) {
    console.log(event.target.value);
    var ul = document.getElementById("autocomplete");
    ul.innerHTML='';
    fetch('autocomplete?q='+event.target.value, {method: 'GET'})
    .then(response => response.json())
    .then(data => {
            data.forEach(element => {
            var li = document.createElement("li");

             // Create anchor element.
            var a = document.createElement('a');       
             // Create the text node for anchor element.
            var link = document.createTextNode(element.title);
             // Append the text node to anchor element.
            a.appendChild(link); 
             // Set the title.
             //a.title = "This is Link"; 
             // Set the href property.
            a.href = "/publication/"+element.id; 
            li.appendChild(a);
            ul.appendChild(li);

    });
    if (event.target.value === ''){
        li.innerHTML = ''
    }
    //li.innerHTML='';
    console.log(data)})
    .catch((error) => console.log(error));
});
