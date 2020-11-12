import { Brand } from '@app/_model/brand';
import { Category } from '@app/_model/category';

export class Equipment {
  id: number;
  name: string;
  uri: string;
  category: Category;
  brand: Brand;
  characteristics: Characteristic[];

  public constructor(equipment: Equipment | undefined) {
    this.characteristics = new Array<Characteristic>();
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
      if (equipment.characteristics) {
        equipment.characteristics.forEach(x => {
          const characteristic = new Characteristic(x);
          characteristic.equipment = this;
          this.characteristics.push(characteristic);
        });
      }
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    if (this.uri) { data[`uri`] = this.uri; }
    if (this.brand) { data[`brand`] = this.brand.toJSON(true); }
    if (this.category) { data[`category`] = this.category.toJSON(true); }
    return data;
  }
}

export class Characteristic {
  id: number;
  name: string;
  value: string;
  unit: string;
  parent: Characteristic;
  subCharacteristic: Characteristic[];
  equipment: Equipment;

  public constructor(characteristic: Characteristic | undefined) {
    this.subCharacteristic = new Array();
    if (characteristic) {
      this.id = characteristic.id;
      this.name = characteristic.name;
      this.value = characteristic.value;
      this.unit = characteristic.unit;
      this.parent = characteristic.parent;
      if (characteristic.subCharacteristic) {
        characteristic.subCharacteristic.forEach(elt => {
          const child = new Characteristic(elt);
          child.parent = this;
          this.subCharacteristic.push(child);
        });
      }
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId === true && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    if (this.value) { data[`value`] = this.value; }
    if (this.unit) { data[`unit`] = this.unit; }
    if (this.parent) { data[`parent`] = this.parent.toJSON(true); }
    return data;
  }
}
