import { BrandCreateComponent } from '@app/_components/brands/brand-create/brand-create.component';
import { Injectable } from '@angular/core';
import { CategoryCreateComponent } from '@app/_components/categories/category-create/category-create.component';

@Injectable({
  providedIn: 'root'
})
export class ComponentCreateRegistryService {

  constructor() { }

  public getComponentByName(name: string) {
    switch (name) {
      case 'CategoryCreate':
        return CategoryCreateComponent;
      case 'BrandCreate':
        return BrandCreateComponent;
      default: return undefined;
    }
  }
}
