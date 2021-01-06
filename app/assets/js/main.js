let filters = {
    views: {
        active: false,
        type: 'more',
        value: 10
    },
    product: {
        active: false,
        value: null
    },
    date: {
        active: false,
        type: 'more',
        value: null,
    }
}

let limit = 10;

function viewsCheckboxClick(checkbox) {
    if (checkbox.checked) {
        filters.views.active = true
        document.getElementById("views-input").disabled = false
        document.getElementById("views-radio1").disabled = false
        document.getElementById("views-radio2").disabled = false
        document.getElementById("views-radio3").disabled = false
        updateData()
    } else {
        filters.views.active = false
        document.getElementById("views-input").disabled = true
        document.getElementById("views-radio1").disabled = true
        document.getElementById("views-radio2").disabled = true
        document.getElementById("views-radio3").disabled = true
        updateData()
    }
}

function viewsRefresh() {
    filters.views.value = document.getElementById("views-input").value

    const radios = document.querySelectorAll('input[name="view-radio"]')

    for (const radio of radios) {
        if (radio.checked) {
            filters.views.type = radio.value
            break
        }
    }

    updateData()
}

function productCheckboxClick(checkbox) {
    if (checkbox.checked) {
        filters.product.active = true
        document.getElementById("product-select").disabled = false

        productRefresh()
    } else {
        filters.product.active = false
        document.getElementById("product-select").disabled = true
        updateData()
    }
}

function productRefresh() {
    const options = document.querySelectorAll('.product-select > option')

    for (const option of options) {
        if (option.selected) {
            filters.product.value = option.value
            break
        }
    }

    updateData()
}

function dateCheckboxClick(checkbox) {
    if (checkbox.checked) {
        filters.date.active = true
        document.getElementById("date-input").disabled = false
        document.getElementById("date-radio1").disabled = false
        document.getElementById("date-radio2").disabled = false
        document.getElementById("date-radio3").disabled = false
        updateData()
    } else {
        filters.date.active = false
        document.getElementById("date-input").disabled = true
        document.getElementById("date-radio1").disabled = true
        document.getElementById("date-radio2").disabled = true
        document.getElementById("date-radio3").disabled = true
        updateData()
    }
}

function dateRefresh() {
    filters.date.value = document.getElementById("date-input").value

    const radios = document.querySelectorAll('input[name="date-radio"]')

    for (const radio of radios) {
        if (radio.checked) {
            filters.date.type = radio.value
            break
        }
    }

    updateData()
}

function limitRefresh() {
    const options = document.querySelectorAll('.limit-select > option')

    for (const option of options) {
        if (option.selected) {
            limit = option.value
            break
        }
    }

    updateData()
}

async function updateData() {
    let query = ''

    if (filters.views.active)
        query += `views_type=${filters.views.type}&views_value=${filters.views.value}`

    if (filters.product.active)
        query += `&product=${filters.product.value}`
    
    if (filters.date.active)
        query += `&date_type=${filters.date.type}&date_value=${filters.date.value}`

    if (limit !== 10)
        query += `&limit=${limit}`

    let response = await fetch(encodeURI(`http://localhost/main/bloglistajax?${query}`))
    let data = await response.json()
    refreshList(data)
}

function refreshList(data) {
    const list = document.getElementById("list")
    list.innerHTML = ''

    data.forEach(item => {
        let listItem = document.createElement("a")
        listItem.classList.add('blog-item')
        listItem.href = `record?href=${item.href}`
        listItem.innerHTML = `
            <div class="blog-item__title">
                <h3>${item.title}</h3>
            </div>

            <div class="blog-item__description">
                <span>${item.description}</span>
            </div>

            <div class="blog-item__stats">
                <span>Просмотров: ${item.views}</span>
                <span>Дата добавления: ${item.date}</span>
            </div>
        `
        list.appendChild(listItem)
    })
    
}