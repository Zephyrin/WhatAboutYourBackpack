export class Backpack {
  id: number;
  name: string;

  public constructor(backpack: Backpack | undefined) {
    if (backpack) {
      this.id = backpack.id;
      this.name = backpack.name;
    }
  }

  toJSON(useId = false) {
    const data = {};
    if (useId && this.id) { data[`id`] = this.id; }
    if (this.name) { data[`name`] = this.name; }
    return data;
  }
}
