<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

    $("#search-adm").keyup(function(){

                var completeAdm = $("#search-adm").val();
                $.ajax({
                    url: '/tcc/selects/select_adm.php',
                    method: 'POST',
                    data: {nome: completeAdm},
                    dataType: 'json'
                }).done(function(result){
                    console.log(result);
                }) 
            }) 

        //ATUALIZANDO EM TEMPO REAL 1s
    function update_adm(){ //função que será carregada
        $.getJSON('base/dashboard/usu_content/adm/painel-control/control_usu.php', function (dados) {
            $('#num-cons-adm').html(dados.total_adm); 
                        if (dados.total_adm < 2) {
                            $('#label-cons-adm').html("Administrador no sistema");
                        }else{
                            $('#label-cons-adm').html("Administradores no sistema");
                        }
        })

        $.getJSON('selects/atv_adm/atv.php', function (dados) {
            $('#num-cons-title').html(dados.num_total_atv);
            $('#adm-cons-add').html(dados.num_add);
            $('#adm-cons-att').html(dados.num_att);
            $('#adm-cons-del').html(dados.num_del);
        })
    }

    //executa a função ao carregar
    $(document).ready(update_adm());
    //Executa a função a cada 3 seg
    setInterval(() => { update_adm(); }, 3000);


    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
//Busca todos os ADM'S 
  $.getJSON('base/crud/admin/consulta/search_adm.php',function(dados) {
    
       adms = [];
          for (let i = 0; i < dados.length; i++) {
             //Pega o nome (Completo) de cada adm
             var nomeCompleto = dados[i].nome;
            //tamanho do nome
            var qtdnome = nomeCompleto.split(" ").length;
            //separando o nome
            var nomeTodo = nomeCompleto.split(" ");
            //primeiro nome
            var primeiroNome = nomeTodo[0].replace(/(^\w{1})/g, letra => letra.toUpperCase());
            //Ultimo nome
            var ultimoNome = nomeTodo[qtdnome-1].replace(/(^\w{1})/g, letra => letra.toUpperCase()); 
            //Nomes do meio
            var nomesmeio = nomeTodo.slice(1, -1);
            // Junta o nome do meio
            var meio = nomesmeio.join(' ');
            // Abrevia o nome
            var nomeMeioAbreviado = meio.replace(/([a-z])\w+/gi, letra => letra.toUpperCase().substr(0, 1)+".");
            //Exibe o nome completo (Abreviando os do meio)
            if (nomeTodo.length > 2) {
              var nomeOut = primeiroNome+" "+nomeMeioAbreviado+" "+ultimoNome;
            } else{
              var nomeOut = nomeTodo;
            }
            //Transforma os dados em varios arrays nome - id
                //nomeId = dados[i].nome+" - "+dados[i].id_usu;
                nomeId = nomeOut+" { "+dados[i].id_usu+" }";
           //Junta todos os arrays em um só
           adms.push(nomeId); 
          }
  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
  autocomplete(document.getElementById("search-adm"), adms);          
}); 

pesq = document.getElementById("search-adm");
setInterval(() => {
    form =  $("#search-adm").val();
    reg = /^[A-Z]([^A-Z\d\s]+)((\s[A-Z]([^A-Z\d\s])+)|(\s[A-Z]([^A-Z\d\s])+)+)\s{1}\{\s([0-9]+)\s\}$/g;
    verificacao = reg.test(form);
    if (verificacao) {
      $("#submit-adm").removeAttr('disabled');
    }else{
      $("#submit-adm").attr('disabled', true);
    }
}, 0);
/* pesq.addEventListener('input', function (inp){
    
    
      if (teste) {
       
      } else {
       
      }
}) */
$("#pesq-adm").submit((e)=>{
  e.preventDefault();
  var id = $("#search-adm").val();
  
 oi = 'João Vsd. Psds. Gs. Mendes { 1 }';
  //Regex para pegar só o id
 
  console.log(oi.replace(/\b[A-Z][^A-Z\d]+\s[A-Z][^\d]+\D[\bA-Z][^[A-Z\d\s]+\s\{\s([0-9]+)\s\}/g, '$1'))
})



 

</script>