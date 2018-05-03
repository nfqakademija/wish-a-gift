let items = 0;

function addElement(giftList, li, giftItem, html) {
    // Add an element to the document
    let div = document.getElementById('#giftList');
    let newElement = document.createElement('li');


    html = '<li><div class="input-group mb-3" id="giftItem">\n'
            `<input type="text" class="form-control" readonly value="${escapeHtml(gift.val())}" />\n` +
            '<div class="input-group-append">\n' +
            '<button type="button" class="btn btn-outline btn-success deleteButton" id="deleteButton">x</button>\n' +
            '</div>\n' +
            '</div></li>';
    newElement.setAttribute('id', html);
    newElement.innerHTML = html;
    div.appendChild(newElement);
}