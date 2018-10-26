
$(document).ready(function(){
		
	$(function(){ //Set active class when page is changed.
		var current_page_URL = location.href;
		$( "a" ).each(function() {
			if ($(this).attr("href") !== "#") {
					
			var target_URL = $(this).prop("href");
					
				if (target_URL == current_page_URL) {
					$('.nav a').parents('li, ul').removeClass('active');
					$(this).parent('li').addClass('active');
					return false;
				}
					
			}
		});
	}); 
		
	//If you want submit a form on a click.
	$("#btn1").click(function(){//Click on element type button id="btn1" to make ajax call.
	
		let data = $("#forma1").serialize();
		event.preventDefault();

		/*Check if there is empty field. If there isn't any empty fields, send serialized data to server. 
		This also works for editing.*/
		if(!(data.indexOf('=&') > -1 || data.substr(data.length - 1) == '=')){
			
			$.ajax({
					type: "GET",//POST or GET
					url: "unos.php",//Where data to send.
					contentType: "text/html",//Regular html format
					data: data,//For displaying use this: print_r($_GET);
					//data: JSON.stringify($("#forma1").serialize()),//Serialization of form. echo(json_encode($_GET));//Should use this if it's jquery ajax json string.
					//contentType:"application/json;charset=utf-8", //If you want json data type.
				   success: function (result) {//If succesfull 
						//console.log(result);
						$("#raport").text(result);//Display in div with id=raport.
						
				   },
				   error: function () {//In case of an error
						alert("Error!!!");
				   }
			});
			
		}
		
	});
	
	$("#forma2").submit(function(event){
		event.preventDefault();//Use this if you want your fields to stay populated after submition.

		$.ajax({
			url: "dis.php",//Where data to send.
			type: "GET",//POST or GET
			contentType: "text/html",//Regular html format
			data: $("#forma2").serialize(),//For displaying use this: print_r($_GET);
			success:function(result){
				//console.log(result);
				if(result!=="0 results"){
				let obj = JSON.parse(result);
				console.log(obj);
				
				let table = "<table id='tabela' class='table table-bordered table-hover table-responsive table-condensed'><thead><tr><th class='text-center'>rowIndex</th><th class='text-center'>Ime</th><th class='text-center'>Prezime</th><th class='text-center'>Datum rodjenja</th><th class='text-center'>Adresa</th><th class='text-center'>Mesto</th><th class='text-center'>Kompanija</th><th class='text-center'>Broj</th><th class='text-center'>Actions</th></tr></thead><tbody>";
				
				let len = obj.id.length;

				for (let i=0;i<len;i++){
					table += "<tr><td class='text-center'>"+i+". <input type='checkbox' style='display:none;' value='"+obj.id[i]+"'></td><td class='text-center'>"+obj.ime[i]+"</td><td class='text-center'>"+obj.prezime[i]+"</td><td class='text-center'>"+obj.datum_rodjenja[i]+"</td><td class='text-center'>"+obj.adresa[i]+"</td><td class='text-center'>"+obj.mesto[i]+"</td><td class='text-center'>"+obj.kompanija[i]+"</td><td class='text-center'>"+obj.broj[i]+"</td><td><button id='br"+i+"' class='btn btn-default btn-xs' onclick='populateModal(this)' data-toggle='modal' data-target='#myModal' style='float: left;'><span class='glyphicon glyphicon-check' title='Edit record'></span></button><button class='btn btn-default btn-xs' style='float: right;' id='"+obj.id[i]+"' onclick='delRecord(this)'><span class='glyphicon glyphicon-remove'  style='color:red;' title='Remove record'></span></button></td>";	
				}
				table += "</tr></tbody></table><button id='csv' class='btn btn-info' onclick='toCSV(`tabela`)'><a id='dCSV' href='' download='myCsv.csv'>toCSV</a></button><button type='button' id='xslx' class='btn btn-info' onclick='fnExcelReport(`tabela`);'>toXslx</button>";
				
				$("#raport").html(table);
			}
			else{
				$("#raport").text("Empty");
			}
			},
			error: function () {//In case of an error
				$("#raport").html('error occured');
			}

		});
	});
	
});

function toCSV(par){
	let tab = document.getElementById(""+par);
	let str = "";
	
	let rowLen = tab.rows.length;
	let cellLen = tab.rows[0].cells.length;
	let tmp = 0;
	for(let i=0;i<rowLen;i++){
		
		for(let j=0;j<cellLen-1;j++){
			
			
			if(tab.rows[i].cells[j].innerHTML.indexOf("<")>=0){
				//console.log(tab.rows[i].cells[j].innerHTML.indexOf("<"));
				tmp = tab.rows[i].cells[j].innerHTML.indexOf(". <");
				str += tab.rows[i].cells[j].innerHTML.substr(0,tmp);
				if(j!==cellLen-2){
					str += ", ";
				}
				
			}
			else{
				str += tab.rows[i].cells[j].innerHTML;
				if(j!==cellLen-2){
					str += ", ";
				}
			}
			
		}
		
		if(i!==rowLen-1){
			str += "\n";
		}

	}
	
	let csvContent = encodeURIComponent(str);
	
	var link = document.createElement("a");
	document.getElementById("dCSV").setAttribute("href", 'data:text/csv;charset=UTF-8,'+csvContent);
	//link.setAttribute("download", "my_data.csv");
	//document.getElementById("csv").appendChild(link); // Required for FF

	//link.click(); 
	
	//console.log(str);
    //window.location.href = 'data:text/csv;charset=UTF-8,'+ csvContent;
}


function fnExcelReport(id, name) {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";
    var exportTable = $('#' + id).clone();
    exportTable.find('input').each(function (index, elem) { $(elem).remove(); });
    tab_text = tab_text + exportTable.html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    var fileName = name + '_' + parseInt(Math.random() * 10000000000) + '.xls';
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, fileName);
        }
    } else {
        var blob2 =  new Blob([tab_text], {
            type: "application/csv;charset=utf-8;"
        });
        var filename = fileName;
            var elem = window.document.createElement('a');
            elem.href = window.URL.createObjectURL(blob2);
            elem.download = filename;
            document.body.appendChild(elem);
            elem.click();
            document.body.removeChild(elem);
    }
}

function populateModal(par1){
	let currentRow=$("#"+par1.id).closest("tr");
	let rowIndex = currentRow.index();
	
	let target = document.getElementById("tabela").children[1].children[rowIndex];
	let targetLen = target.childElementCount;
	
	let chck1 = target.children[0].children[0];
	let chckVal1 = chck1.value;
	let arr1 = [];
	
	arr1.push(chck1.checked);
	
	arr1.push(parseInt(chckVal1));
	for(let i=1;i<targetLen-1;i++){
		arr1.push(target.children[i].innerHTML);
	}
	
	//console.log(arr1);
	/*
		arr1[0] == cekirano ili ne;
		arr1[1] == ajdi;
		arr1[2] == ime;
		arr1[3] == prezime;
		arr1[7] == kompanija;
		arr1[5] == adresa;
		arr1[6] == mesto;
		arr1[4] == datum;
		arr1[8] == broj;
	*/
	let modal = "<div class='container' id='cont'><div class='modal fade' id='myModal' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Modal Header</h4></div><div class='modal-body'><form id='forma3' class='form-horizontal text-center'><div class='form-group'> <label for='ime1'>Ime:</label><input type='text' class='form-control inp' id='ime1' placeholder='Unesi ime' name='ime1' maxlength='255' value="+arr1[2]+"></div><div class='form-group'><label for='prezime1'>Prezime:</label><input type='text' class='form-control inp' id='prezime1' placeholder='Unesi prezime' name='prezime1' maxlength='255' value="+arr1[3]+"></div><div class='form-group'><label for='kompanija1'>Kompanija:</label><input type='text' class='form-control inp' id='kompanija1' placeholder='Unesi kompaniju' name='kompanija1' maxlength='255' value="+arr1[7]+"></div><div class='form-group'><label for='adresa1'>Adresa:</label><input type='text' class='form-control inp' id='adresa1' placeholder='Unesi adresu' name='adresa1' maxlength='255' value="+arr1[5]+"></div><div class='form-group'><label for='mesto1'>Mesto:</label><input type='text' class='form-control inp' id='mesto1' placeholder='Unesi mesto rođenja' name='mesto1' maxlength='255' value="+arr1[6]+"></div><div class='form-group'><label for='datum1'>Datum rođenja:</label><input type='date' class='form-control inp' id='datum1' placeholder='Unesi datum rođenja' name='datum1' value="+arr1[4]+"></div><div class='form-group'><label for='broj1'>Telefonski broj:</label><input type='number' class='form-control inp' id='broj1' placeholder='Enter Phone Number' name='broj1' maxlength='10' value="+arr1[8]+"></div><div class='form-group'><label for='id'></label><input type='number' id='mojAjdi' name='mojAjdi' value='"+arr1[1]+"' style='width: 10%; text-align: right;display: none;'></div></form><div class='modal-footer'><button class='btn btn-default' style='float: left;' id='save' onclick='update()' data-dismiss='modal'>Save</button><button type='button' class='btn btn-default' data-dismiss='modal'>Close</button></div></div></div> </div></div>";
	
	document.getElementById("modalka").innerHTML = modal;
	
	let arr2 = [];
	
}

function update(){
	let data = $("#forma3").serialize();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			let obj = JSON.parse(this.responseText);
			//console.log(obj);
			
			let table = "<table id='tabela' class='table table-bordered table-hover table-responsive table-condensed'><thead><tr><th class='text-center'>rowIndex</th><th class='text-center'>Ime</th><th class='text-center'>Prezime</th><th class='text-center'>Datum rodjenja</th><th class='text-center'>Adresa</th><th class='text-center'>Mesto</th><th class='text-center'>Kompanija</th><th class='text-center'>Broj</th><th class='text-center'>Actions</th></tr></thead><tbody>";
			
			let len = obj.id.length;

			for (let i=0;i<len;i++){
				table += "<tr><td class='text-center'>"+i+". <input type='checkbox' style='display:none;' value='"+obj.id[i]+"'></td><td class='text-center'>"+obj.ime[i]+"</td><td class='text-center'>"+obj.prezime[i]+"</td><td class='text-center'>"+obj.datum_rodjenja[i]+"</td><td class='text-center'>"+obj.adresa[i]+"</td><td class='text-center'>"+obj.mesto[i]+"</td><td class='text-center'>"+obj.kompanija[i]+"</td><td class='text-center'>"+obj.broj[i]+"</td><td><button id='br"+i+"' class='btn btn-default btn-xs' onclick='populateModal(this)' data-toggle='modal' data-target='#myModal' style='float: left;'><span class='glyphicon glyphicon-check' title='Edit record'></span></button><button class='btn btn-default btn-xs' style='float: right;' id='"+obj.id[i]+"' onclick='delRecord(this)'><span class='glyphicon glyphicon-remove' style='color:red;' title='Remove record'></span></button></td></tr>";	
			}
			table += "</tbody></table><button type='button' id='csv' class='btn btn-info' onclick='toCSV(`tabela`)'><a id='dCSV' href='' download='myCsv.csv'>toCSV</a></button><button type='button' id='xslx' class='btn btn-info' onclick='fnExcelReport(`tabela`);'>toXslx</button>";

			document.getElementById("raport").innerHTML = table;
		}
	};
	xmlhttp.open("GET", "update.php?" + data, true);
	xmlhttp.send();
	
}

function delRecord(par1){
	
	let checkboxes = $('input[type=checkbox]:checked');//array
	var target = document.getElementById('tabela');
	let arrx = [];
	let len = target.rows[0].cells.length
	
	for(let i=0;i<len;i++){
		arrx.push(target.rows[0].cells[i].innerHTML);
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			
			if(this.responseText!=="0 results"){
			let obj = JSON.parse(this.responseText);
			//console.log(this.responseText);
			//console.log(obj);
			
			let table = "<table id='tabela' class='table table-bordered table-hover table-responsive table-condensed'><thead><tr><th class='text-center'>rowIndex</th><th class='text-center'>Ime</th><th class='text-center'>Prezime</th><th class='text-center'>Datum rodjenja</th><th class='text-center'>Adresa</th><th class='text-center'>Mesto</th><th class='text-center'>Kompanija</th><th class='text-center'>Broj</th><th class='text-center'>Actions</th></tr></thead><tbody>";
			
			let len = obj.id.length;

			for (let i=0;i<len;i++){
				table += "<tr><td class='text-center'>"+i+". <input type='checkbox' style='display:none;' value='"+obj.id[i]+"'></td><td class='text-center'>"+obj.ime[i]+"</td><td class='text-center'>"+obj.prezime[i]+"</td><td class='text-center'>"+obj.datum_rodjenja[i]+"</td><td class='text-center'>"+obj.adresa[i]+"</td><td class='text-center'>"+obj.mesto[i]+"</td><td class='text-center'>"+obj.kompanija[i]+"</td><td class='text-center'>"+obj.broj[i]+"</td><td><button id='br"+i+"' class='btn btn-default btn-xs' onclick='populateModal(this)' data-toggle='modal' data-target='#myModal' style='float: left;'><span class='glyphicon glyphicon-check' title='Edit record'></span></button><button class='btn btn-default btn-xs' style='float: right;' id='"+obj.id[i]+"' onclick='delRecord(this)'><span class='glyphicon glyphicon-remove' style='color:red;' title='Remove record'></span></button></td></tr>";	
			}
			table += "</tbody></table><button type='button' id='csv' class='btn btn-info' onclick='toCSV(`tabela`)'><a id='dCSV' href='' download='myCsv.csv'>toCSV</a></button><button type='button' id='xslx' class='btn btn-info' onclick='fnExcelReport(`tabela`);'>toXslx</button>";

			document.getElementById("raport").innerHTML = table;
		}
		else{
			document.getElementById("raport").innerHTML = "Empty";
		}
		}
	};
	xmlhttp.open("GET", "delete.php?q=" + par1.id, true);
	xmlhttp.send();
	
}