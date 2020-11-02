export class Category {
  id: number;
  name: string;
  parent: Category;
  subCategories: Category[];

  public constructor(category: Category | undefined) {
    this.subCategories = new Array();
    if (category) {
      this.id = category.id;
      this.name = category.name;
      this.parent = category.parent;
      if (category.subCategories) {
        category.subCategories.forEach(elt => {
          const child = new Category(elt);
          child.parent = this;
          this.subCategories.push(new Category(elt));
        });
      }
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId === true && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    if (this.parent) { data[`parent`] = this.parent.toJSON(true); }
    return data;
  }
}
