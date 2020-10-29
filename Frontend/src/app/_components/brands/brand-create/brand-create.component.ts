import { MatDialogRef } from '@angular/material/dialog';
import { FormBuilder } from '@angular/forms';
import { BrandsService } from '@app/_services/brands/brands.service';
import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { Component } from '@angular/core';

@Component({
  selector: 'app-brand-create',
  templateUrl: './brand-create.component.html',
  styleUrls: ['./brand-create.component.scss']
})
export class BrandCreateComponent extends ChildCreateFormBaseComponent {

  constructor(
    public dialogRef: MatDialogRef<BrandCreateComponent>,
    public service: BrandsService,
    protected formBuilder: FormBuilder) {
    super(dialogRef, service, formBuilder);
  }

  init() {
  }
}
