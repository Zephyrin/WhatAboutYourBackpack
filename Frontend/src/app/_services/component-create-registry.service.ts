import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { ComponentType } from '@angular/cdk/portal';
import { BrandCreateComponent } from '@app/_components/brands/brand-create/brand-create.component';
import { Injectable } from '@angular/core';
import { CategoryCreateComponent } from '@app/_components/categories/category-create/category-create.component';

@Injectable({
  providedIn: 'root'
})
export class ComponentCreateRegistryService {

  constructor() { }

  public getComponentByName(name: string): ComponentType<ChildCreateFormBaseComponent> {
    switch (name) {
      case 'CategoryCreate':
        return CategoryCreateComponent;
      case 'BrandCreate':
        return BrandCreateComponent;
      default: throw new Error(name + ' n\'est pas définie dans ComponentCreateRegistryService. Je ne sais quelle fenêtre afficher...');
    }
  }
}
