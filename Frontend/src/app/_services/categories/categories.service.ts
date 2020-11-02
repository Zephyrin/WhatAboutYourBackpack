import { CategoriesSearchService } from './categories-search.service';
import { FormBuilder, Validators } from '@angular/forms';
import { CategoriesHttpService } from './categories-http.service';
import { CService } from '@app/_services/iservice';
import { Category } from '@app/_model/category';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CategoriesService extends CService<Category> {
  private nbEnumLeft = 0;

  constructor(
    private h: CategoriesHttpService
  ) {
    super(h, new CategoriesSearchService());
  }

  public initEnums(): void {
    if (this.headers.length === 0) {
      this.headers.push({ value: 'name', viewValue: 'Nom' });
      this.displayedColumns.push('name');
    }
    this.initEnumDone.next(true);
  }

  public create(): Category {
    return new Category(undefined);
  }

  public createCpy(value: Category): Category {
    return new Category(value);
  }

  public endUpdateOk(value: Category): void {
    if (value.parent) {
      const index = this.model.findIndex(elt => elt.id === value.id);
      if (index >= 0) {
        const cat = this.model[index];
        this.model.splice(index, 1);
        value.parent.subCategories.push(cat);
      }
    }
  }

  public createFormBasedOn(formBuilder: FormBuilder, value: Category): void {
    if (this.selected && this.selected.id !== value.id) {
      value.parent = this.selected;
    }
    this.form = formBuilder.group({
      id: [''],
      name: ['', Validators.required],
      parent: ['']
    });
  }

  public getDisplay(name: string, value: Category): any {
    switch (name) {
      case 'id':
        return value[name];
      case 'name':
        return value[name];
      case 'parent':
        return value.parent?.name;
      default:
        break;
    }
    return value[name];
  }
}
