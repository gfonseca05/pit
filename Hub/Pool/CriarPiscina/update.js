function alterDate() {
    var nextClean = document.getElementById("nextClean").value;
    document.getElementById("nextClean").value = "";
    document.getElementById("lastClean").value = nextClean;
}

function formatDate(input) {
    let value = input.value;
    value = value.replace(/\D/g, '');
  
    if (value.length > 4) {
      value = value.replace(/^(\d{4})(\d{2})(\d{0,2})(\d{0,2})$/, '$1-$2-$3');
    } else if (value.length > 2) {
      value = value.replace(/^(\d{4})(\d{0,2})$/, '$1-$2');
    }
    
    input.value = value;
  }
  