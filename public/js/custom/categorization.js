class Dropdown {
    constructor(name, element, previous) {
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

        if(previous instanceof Dropdown) {
            previous.registerSibling(this);
        } else if(previous !== null) {
            throw new Error('The previous sibling given should be Dropdown or null');
        }

        if(!previous && element.children.length === 0) {
            this.reloadOptions();
        }
    }

    onChange() {
        if(this.next instanceof Dropdown) {
            this.next.reloadOptions(this);
        }
    }

    registerSibling(next) {
        this.next = next;

        if(this.element.selectedIndex > 0 || next.element.children.length === 0) {
            this.onChange();
        }
    }

    reloadOptions(source) {
        let ID = '';

        this.element.disabled = true;

        if(source instanceof Dropdown) {
            ID += '-' + source.element.selectedOptions[0].value;
        }

        $.getJSON('/data/' + this.name + ID + '.json', (data) => this.updateOptions(data));
    }

    updateOptions(data) {
        this.element.innerHTML = '';

        for(let i = 0; i < data.length; i++) {
            let child = document.createElement('option');

            child.value = data[i].id;
            child.innerText = data[i].name;

            this.element.add(child);
        }

        this.element.disabled = false;
    }
}

class Categorization {
    constructor(selectionForm, modificationForm) {
        this.selectionForm = selectionForm;
        this.modificationForm = modificationForm;
    }

    registerSelector(name, previous) {
        let select = this.selectionForm.elements.namedItem('selected-' + name);

        if(select) {
            return new Dropdown(name, select, previous);
        }

        return null;
    }

    registerModifier(name, previous) {
        let select = this.modificationForm.elements.namedItem('new-' + name);

        if(select) {
            return new Dropdown(name, select, previous);
        }

        return null;
    }
}

let previous = null;
let categorization = new Categorization(
    document.getElementById('selection'),
    document.getElementById('modifications')
);

previous = null;
['subcategories', 'productgroups'].forEach((name) => {
    previous = categorization.registerSelector(name, previous);
});

previous = null;
['categories', 'subcategories'].forEach((name) => {
    previous = categorization.registerModifier(name, previous);
});