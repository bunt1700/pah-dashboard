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
        let filename = this.name;

        filename = filename.replace(/y$/, 'ie');
        filename += 's';

        this.element.disabled = true;

        if(source instanceof Dropdown) {
            filename += '-' + source.element.selectedOptions[0].value;
        }

        $.getJSON('/data/' + filename + '.json', (data) => this.updateOptions(data));
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

class Inputbox {
    constructor(element, button, sibling) {
        if(element instanceof HTMLInputElement) {
            element.addEventListener('keyup', () => this.onChange());
        } else {
            throw new Error('Invalid input element supplied!');
        }

        if(button instanceof HTMLButtonElement) {
            this.button = button;
        } else {
            throw new Error('Invalid button element supplied!');
        }

        this.filled = false;
        this.sibling = null;
        this.element = element;

        if(sibling instanceof HTMLSelectElement) {
            this.sibling = sibling;
        }

        if(this.element.value) {
            this.onChange();
        }
    }

    onChange() {
        let filled = (this.element.value.trim().length > 0);

        if(filled !== this.filled) {
            this.button.innerText = filled ? 'Aanmaken' : 'Selecteren';

            if(this.sibling) {
                this.sibling.disabled = filled;
            }

            this.filled = filled;
        }
    }
}

class Categorization {
    constructor(modificationForm, selectionForms) {
        this.modificationForm = modificationForm;
        this.selectionForms = selectionForms;
    }

    registerModifier(name, previous) {
        let select = this.modificationForm.elements.namedItem('target-' + name);

        if(select) {
            return new Dropdown(name, select, previous);
        }

        return null;
    }

    registerSelector(name) {
        let input = null;
        let button = null;
        let sibling = null;

        for(let i = 0; i < this.selectionForms.length; i++) {
            input = this.selectionForms[i].elements.namedItem('new-' + name);

            if(input) {
                button = this.selectionForms[i].getElementsByTagName('button').item(0);
                sibling = this.selectionForms[i].getElementsByTagName('select').item(0);
                break;
            }
        }

        if(input) {
            return new Inputbox(input, button, sibling);
        }

        return null;
    }
}

let categorization = new Categorization(
    document.getElementById('modifications'),
    document.getElementsByClassName('selection')
);

let previous = null;
['category', 'subcategory'].forEach((name) => {
    previous = categorization.registerModifier(name, previous);
});

['subcategory', 'productgroup'].forEach((name) => {
    categorization.registerSelector(name);
});