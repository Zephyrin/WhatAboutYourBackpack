export class Brand {
  id: number;
  name: string;
  uri: string;

  public constructor(brand: Brand | undefined) {
    if (brand) {
      this.id = brand.id;
      this.name = brand.name;
      this.uri = brand.uri;
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    if (this.uri) { data[`uri`] = this.uri; }
    return data;
  }
}
