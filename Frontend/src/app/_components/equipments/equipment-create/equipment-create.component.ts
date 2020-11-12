import { BrandsService } from '@app/_services/brands/brands.service';
import { EquipmentsService } from '@app/_services/equipments/equipments.service';
import { Subscription } from 'rxjs';
import { FormBuilder } from '@angular/forms';
import { MatDialogRef } from '@angular/material/dialog';
import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { Component } from '@angular/core';
import { CategoriesService } from '@app/_services/categories/categories.service';
import { COMMA, ENTER } from '@angular/cdk/keycodes';
import { ArrayDataSource } from '@angular/cdk/collections';
import { MatChipInputEvent } from '@angular/material/chips';
import { NestedTreeControl } from '@angular/cdk/tree';
import { Category } from '@app/_model/category';

@Component({
  selector: 'app-equipment-create',
  templateUrl: './equipment-create.component.html',
  styleUrls: ['./equipment-create.component.scss']
})
export class EquipmentCreateComponent extends ChildCreateFormBaseComponent {
  private serviceSubscription: Subscription;
  private categoryServiceSubscription: Subscription;

  treeControl = new NestedTreeControl<Category>(node => node.subCategories);
  dataSource: ArrayDataSource<Category> = new ArrayDataSource([]);
  separatorKeysCodes: number[] = [ENTER, COMMA];
  hasChild = (_: number, node: Category) => !!node.subCategories && node.subCategories.length > 0;

  constructor(
    public dialogRef: MatDialogRef<EquipmentCreateComponent>,
    public service: EquipmentsService,
    public categoryService: CategoriesService,
    public brandService: BrandsService,
    protected formBuilder: FormBuilder) {
    super(dialogRef, service, formBuilder);
    brandService.load(false);
    categoryService.load(false);
    this.categoryServiceSubscription = categoryService.endUpdate.subscribe(x => {
      this.dataSource = new ArrayDataSource(categoryService.model);
    });
    this.serviceSubscription = this.service.endUpdate.subscribe(x => {
      if (x === true) {

      }
    });
  }

  public destroy(): void {
    if (this.serviceSubscription) { this.serviceSubscription.unsubscribe(); }
    if (this.categoryServiceSubscription) { this.categoryServiceSubscription.unsubscribe(); }

  }

  compareId(c1: any, c2: any): boolean {
    return c1 && c2 ? c1.id === c2.id : c1 === c2;
  }

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if (value) {
      this.service.form.patchValue({ category: value });
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.service.form.setValue(null);
  }

  remove(fruit: string): void {
    this.service.form.patchValue({ category: undefined });
  }
}
