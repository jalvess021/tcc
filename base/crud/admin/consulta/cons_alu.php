<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<div class="d-flex flex-row justify-content-between">
    <h3 class="content-title">Consulta</h3>	
    <!-- Chama o Formulário para adicionar Cursos -->
   <!-- <a href="?content_adm=lista_aula&add=aula" class="btn bt-padrao btn-lg float-right">Relatório completo</a> -->
</div>
<div class="d-flex flex-row justify-content-between mt-4 cons-area">
	<div class="table-responsive col-md-12 col-md-12 all-table">
		<div class="all-table-header">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand cons-adm" href="?content_adm=consulta_alu" title='Início'><i class='bi bi-person-lines-fill'></i> Alunos</a>
            <form class="form-inline pesq-usu-cons" id="pesq-alu">
                <input class="form-control mr-sm-2 search-usu" type="search" id="search-alu" placeholder="Nome { ID }" aria-label="Search" autocomplete='off'>
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit" id='submit-alu' disabled>Pesquisar</button>
            </form>
        </nav>  
				<hr>
		</div>
		<div class="all-table-body" id='cons-main-adm'>
			<?php include "main_alu/ch_cons_main.php";?>  
		</div>
	</div>
</div>
<script>


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
  $.getJSON('base/crud/admin/consulta/search_alu.php',function(dados) {
    
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
            var nomeMeioAbreviado = meio.replace(/([a-z])\w[a-záâãéêíóôõ]+/gi, letra => letra.toUpperCase().substr(0, 1)+".");
            console.log(nomeMeioAbreviado);
            //Exibe o nome completo (Abreviando os do meio)
            if (nomeTodo.length > 2) {
              var nomeOut = primeiroNome+" "+nomeMeioAbreviado+" "+ultimoNome;
            } else{
              var nomeOut = nomeTodo.join(' ');
            }
            
            //Transforma os dados em varios arrays nome - id
                //nomeId = dados[i].nome+" - "+dados[i].id_usu;
                nomeId = nomeOut+" { "+dados[i].id_usu+" }";
           //Junta todos os arrays em um só
           adms.push(nomeId); 
          }
  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
  autocomplete(document.getElementById("search-alu"), adms);          
}); 
//Realiza a funçao em tempo real 0s
setInterval(() => {
    //Valor que está sendo digitado
    form =  $("#search-alu").val();
    //Regex (Expressão regular)
    reg = /^[A-Z]([^A-Z\d\s]+)((\s[A-Z]([^A-Z\d\s])+)|(\s[A-Z]([^A-Z\d\s])+)+)\s{1}\{\s([0-9]+)\s\}$/g;
    //Verificar se está preenchido corretamente
    verificacao = reg.test(form);
    //Condicao se a verificacao for verdadeira
    if (verificacao) {
      //Busca todos os administradores
      $.getJSON('base/crud/admin/consulta/search_alu.php', function (data) {
        //Pega apenas o id do administrador que ele quer buscar
        id_verify = form.replace(reg, "$7");
        //Cria um array para armazenar os dados
        id_existente = [];
        //Pega todos os id's existentes
        for (let i = 0; i < data.length; i++) {
          //Armazena todos os id's em um array
          id_existente.push(data[i].id_usu);
        }
        //Verifica se o que ele busca (Id) existe
        if (id_existente.includes(id_verify)){
          $("#submit-alu").removeAttr('disabled');
        }else{
          $("#submit-alu").attr('disabled', true);
        }
      });
    }
}, 0);

$("#pesq-alu").submit((e)=>{
    e.preventDefault();
    var valInput = $("#search-alu").val();
    
    
    //Regex (Expressão regular)
    reg1 = /^[A-Z]([^A-Z\d\s]+)((\s[A-Z]([^A-Z\d\s])+)|(\s[A-Z]([^A-Z\d\s])+)+)\s{1}\{\s([0-9]+)\s\}$/g;
    //Pega apenas o id do administrador que ele quer buscar
    idSearch = valInput.replace(reg1, "$7");
    $.ajax({
            url: 'base/crud/admin/consulta/search_alu2.php',
            method: 'POST',
            data: {searchAluInput: idSearch},
            datatype: 'json'
        }).done(function(result){
            dados = result;
            var num = dados.replace(/[^0-9]/g,'');
            idAdm = parseInt(num);
            //idCripto = btoa(idAdm);
            window.location.href = "?content_adm=consulta_alu&info=view&alu="+idAdm;
        }) 
    }) 

</script>


