import { FormBuilder } from '@angular/forms';
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
    super(h, undefined);
  }

  public initEnums(): void {
    this.initEnumDone.next(true);
  }

  public create(): Category {
    return new Category(undefined);
  }

  public createCpy(value: Category): Category {
    return new Category(value);
  }

  public createFormBasedOn(formBuilder: FormBuilder, value: Category): void {
    this.form = formBuilder.group({
      id: [''],

    });
  }

  public getDisplay(name: string, value: Category): any {
    switch (name) {
      case 'id':
        return value[name];
      default:
        break;
    }
    return value[name];
  }
}
