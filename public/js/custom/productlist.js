class Filter {
    constructor(productlist) {
        this.productlist = productlist;
    }

    updateProductList() {
        this.productlist.reloadProducts(this);
    }
}

class DropdownFilter extends Filter {
    constructor(productlist, name, element, previous) {
        super(productlist);

        this.name = name;
        this.element = element;
        this.previous = previous;
        this.next = null;

        if(typeof name !== 'string') {
            throw new Error('Name must be string');
        }

        if(element instanceof HTMLSelectElement) {
            element.addEventListener('change', () => this.onChange());
        } else {
            throw new Error('Invalid select element supplied!');
        }

        if(previous instanceof DropdownFilter) {
            previous.registerSibling(this);
        } else if(previous !== null) {
            throw new Error('The previous sibling given should be DropdownFilter or null');
        }

        if(!previous && element.children.length === 1) {
            this.reloadOptions();
        }
    }

    onChange() {
        if(this.next instanceof DropdownFilter) {
            this.next.reloadOptions(this);
        } else {
            this.updateProductList();
        }
    }

    registerSibling(next) {
        this.next = next;
    }

    reloadOptions(source) {
        let ID = '';

        this.element.disabled = true;

        if(source instanceof DropdownFilter && source.element.selectedIndex) {
            ID += '-' + source.element.selectedOptions[0].value;
        }

        $.getJSON('/data/' + this.name + ID + '.json', (data) => this.updateOptions(data));
    }

    updateOptions(data) {
        for(let i = 1; i < this.element.children.length; i++) {
            this.element.removeChild(this.element.children[i]);
        }

        for(let i = 0; i < data.length; i++) {
            let child = document.createElement('option');

            child.value = data[i].id;
            child.innerText = data[i].name;

            this.element.add(child);
        }

        this.element.disabled = false;
    }
}

class ProductList {
    constructor(form) {
        if(form instanceof HTMLFormElement) {
            this.form = form;
        } else {
            throw new Error('ProductList should be instantiated for a form');
        }
    }

    registerDropdown(name, previous) {
        let select = this.form.elements.namedItem('filter-' + name);
        return new DropdownFilter(this, name, select, previous);
    }

    reloadProducts(filter) {
        this.form.submit();
    }
}

let productlist = new ProductList(document.getElementById('filters'));

let previous = null;
['categories', 'subcategories', 'productgroups'].forEach((name) => {
    previous = productlist.registerDropdown(name, previous);
});