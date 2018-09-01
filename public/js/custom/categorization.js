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
        for(let i = 0; i < Math.max(data.length, this.element.children.length); i++) {
            let child = this.element.children[i];

            if(i < data.length) {
                if (child instanceof HTMLOptionElement) {
                    if (child.innerText != data[i].name) {
                        let modified = document.createElement('option');

                        modified.value = data[i].id;
                        modified.innerText = data[i].name;

                        this.element.replaceChild(modified, child);
                    }
                } else {
                    let addition = document.createElement('option');

                    addition.value = data[i].id;
                    addition.innerText = data[i].name;

                    this.element.add(addition);
                }
            } else {
                this.element.removeChild(child);
            }
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