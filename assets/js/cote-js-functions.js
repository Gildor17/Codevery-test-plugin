if (typeof coteWidgetList==='undefined') {var coteWidgetList = [];}

function cote_ajaxGetDropdownElements() {
    let xhttp = new XMLHttpRequest(),
        // sendData = 'type=saveStat&data='+dataToSend,
        sendData = 'type=getWidgetData',
        url = cote_ajaxurl+'?action=ajaxGetWidgetData';

    // let getWidgetDropdown = document.querySelector('#cote-widget-dropdown');
    let getWidgetDropdown = document.querySelector('.cote-widget-dropdown');
    if (getWidgetDropdown.classList.contains('dataLoaded')) {
        return false;
    }

    xhttp.onload = function(redata) {
        console.log('test ajax stat loaded');
        console.log('cote_c_res', redata['srcElement']['response']);
        if (redata&&redata["srcElement"]&&(redata["srcElement"]["status"]==200)&&redata["srcElement"]["response"]) {
            coteWidgetList = JSON.parse(redata["srcElement"]["response"]);
            if (coteWidgetList&&coteWidgetList.length > 0) {
                for (let i = 0; i < coteWidgetList.length; i++) {
                    let newOption = new Option(coteWidgetList[i]['postal_code'], i, false, false);
                    jQuery('.cote-widget-dropdown').append(newOption).trigger('change');

                    // let tempElement = document.createElement('a');
                    // tempElement.dataset.id = i;
                    // tempElement.innerHTML= coteWidgetList[i]['postal_code'];
                    // getWidgetDropdown.append(tempElement);
                }
            }
        }
    }
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(sendData);

    return true;
}

function coteChangeWidgetSelect(state) {
    console.log('selection state', state);
}

function coteDropdownFunction() {
    document.getElementById("cote-widget-dropdown").classList.toggle("cote-widget-show");
    cote_ajaxGetDropdownElements();
}

function coteDropdownFilterFunction() {
    let input, filter, ul, li, dropElements, i, dropCore;
    input = document.getElementById("cote-widget-input");
    filter = input.value.toUpperCase();
    dropCore = document.getElementById("cote-widget-dropdown");
    dropElements = dropCore.getElementsByTagName("a");
    for (i = 0; i < dropElements.length; i++) {
        txtValue = dropElements[i].textContent || dropElements[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            dropElements[i].style.display = "";
        } else {
            dropElements[i].style.display = "none";
        }
    }
}


//search still unfinished and css too
jQuery(document).ready(function() {
    jQuery('.cote-widget-dropdown').select2({
        placeholder: "Select a state",
        allowClear: true
        // templateSelection: coteChangeWidgetSelect
    }).on('select2:select', function (e) {
        let infoBlock = document.querySelector('.cote-widget-info-div');
        if (infoBlock&&coteWidgetList&&coteWidgetList.length > 0) {
            let currentElementInfo = coteWidgetList[e.currentTarget.selectedIndex];

            infoBlock.querySelector('.cote-widget-city').innerHTML = currentElementInfo['city'];
            infoBlock.querySelector('.cote-widget-phone').innerHTML = currentElementInfo['phone'];
            infoBlock.querySelector('.cote-widget-email').innerHTML = currentElementInfo['email'];
            infoBlock.querySelector('.cote-widget-website').innerHTML = currentElementInfo['website'];
            infoBlock.querySelector('.cote-widget-image').src = currentElementInfo['images'];
        }
    });

    cote_ajaxGetDropdownElements();
});