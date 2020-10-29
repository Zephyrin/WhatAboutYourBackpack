import { Brand } from '@app/_model/brand';
import { Category } from '@app/_model/category';

export class Equipment {
  id: number;
  name: string;
  uri: string;
  category: Category;
  brand: Brand;

  public constructor(equipment: Equipment | undefined) {
    if (equipment) {
      this.id = equipment.id;
      this.name = equipment.name;
      this.uri = equipment.uri;
      if (equipment.brand) {
        this.brand = new Brand(equipment.brand);
      }
      if (equipment.category) {
        this.category = new Category(equipment.category);
      }
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    if (this.uri) { data[`uri`] = this.uri; }
    if (this.brand) { data[`brand`] = this.brand.toJSON(); }
    if (this.category) { data[`category`] = this.category.toJSON(); }
    return data;
  }
}
