if (typeof coteWidgetList==='undefined') {var coteWidgetList = {};}

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
        if (redata&&redata["srcElement"]&&(redata["srcElement"]["status"]===200)&&redata["srcElement"]["response"]) {
            coteWidgetList = JSON.parse(redata["srcElement"]["response"]);
            if (coteWidgetList&&(typeof coteWidgetList === "object")&&(Object.keys(coteWidgetList).length > 0)) {
                let widgetDropdown = jQuery('.cote-widget-dropdown');
                Object.entries(coteWidgetList).forEach(([key1, value1]) => {
                    let newOption = new Option(key1, key1, false, false);
                    widgetDropdown.append(newOption);
                });

                widgetDropdown.trigger({type: 'select2:select'});
            }
        }
    }
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(sendData);

    return true;
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
        placeholder: "Select an index",
        allowClear: true
    }).on('select2:select', function (e) {
        console.log('here1');
        let widgetDropdown2 = jQuery('.cote-widget-dropdown-2'),
            // currentElementInfo = coteWidgetList[e.currentTarget.selectedIndex];
            currentElementInfo = coteWidgetList[e.currentTarget.value];

        widgetDropdown2.empty();

        Object.entries(currentElementInfo).forEach(([key1, value1]) => {
            let newOption = new Option(value1['franchise_name'], key1, false, false);
            newOption.dataset.postal = e.currentTarget.value;
            widgetDropdown2.append(newOption);
        });
        widgetDropdown2.trigger({type: 'select2:select'});
    }).on('select2:clear', function (e) {
        let widgetDropdown2 = jQuery('.cote-widget-dropdown-2');
        if (!widgetDropdown2) {
            return false;
        }

        widgetDropdown2.empty();
        widgetDropdown2.trigger({type: 'select2:clear'});
    });

    jQuery('.cote-widget-dropdown-2').select2({
        placeholder: "Select a region",
        allowClear: true
    }).on('select2:select', function (e) {
        console.log('here2');
        let infoBlock = document.querySelector('.cote-widget-info-div');
        if (infoBlock&&coteWidgetList&&(typeof coteWidgetList === "object")&&(Object.keys(coteWidgetList).length > 0)) {
            let widgetDropdown2 = jQuery('.cote-widget-dropdown-2'),
                currentElementInfo = coteWidgetList[e.currentTarget.selectedOptions[0].dataset.postal][e.currentTarget.value];

            if (widgetDropdown2&&currentElementInfo) {
                infoBlock.querySelector('.cote-widget-franchise-name').innerHTML = currentElementInfo['franchise_name'];
                infoBlock.querySelector('.cote-widget-phone').innerHTML = currentElementInfo['phone'];
                infoBlock.querySelector('.cote-widget-email').innerHTML = currentElementInfo['email'];
                infoBlock.querySelector('.cote-widget-website').innerHTML = currentElementInfo['website'];
                infoBlock.querySelector('.cote-widget-city').innerHTML = currentElementInfo['city']+",";
                infoBlock.querySelector('.cote-widget-region').innerHTML = currentElementInfo['region']+",";
                infoBlock.querySelector('.cote-widget-state').innerHTML = currentElementInfo['state'];
                infoBlock.querySelector('.cote-widget-image').src = currentElementInfo['images'];
            }
        }
    }).on('select2:clear', function (e) {
        let infoBlock = document.querySelector('.cote-widget-info-div');
        if (!infoBlock) {
            return false;
        }

        infoBlock.querySelector('.cote-widget-franchise-name').innerHTML =
        infoBlock.querySelector('.cote-widget-phone').innerHTML =
        infoBlock.querySelector('.cote-widget-email').innerHTML =
        infoBlock.querySelector('.cote-widget-website').innerHTML =
        infoBlock.querySelector('.cote-widget-city').innerHTML =
        infoBlock.querySelector('.cote-widget-region').innerHTML =
        infoBlock.querySelector('.cote-widget-state').innerHTML =
        infoBlock.querySelector('.cote-widget-image').src = "";
    });

    cote_ajaxGetDropdownElements();
});