import { Subscription } from 'rxjs';
import { Category } from '@app/_model/category';
import { FormBuilder } from '@angular/forms';
import { MatDialogRef } from '@angular/material/dialog';
import { CategoriesService } from '@app/_services/categories/categories.service';
import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { Component } from '@angular/core';

@Component({
  selector: 'app-category-create',
  templateUrl: './category-create.component.html',
  styleUrls: ['./category-create.component.scss']
})
export class CategoryCreateComponent extends ChildCreateFormBaseComponent {
  private serviceSubscription: Subscription;
  constructor(
    public dialogRef: MatDialogRef<CategoryCreateComponent>,
    public service: CategoriesService,
    protected formBuilder: FormBuilder) {
    super(dialogRef, service, formBuilder);
    this.serviceSubscription = this.service.endUpdate.subscribe(x => {
      if (x === true) {

      }
    });
  }

  public destroy(): void {
    if (this.serviceSubscription) { this.serviceSubscription.unsubscribe(); }
  }

  compareParent(c1: Category, c2: Category): boolean {
    return c1 && c2 ? c1.id === c2.id : c1 === c2;
  }

  arry(n: number): any[] {
    return Array(n);
  }
}
