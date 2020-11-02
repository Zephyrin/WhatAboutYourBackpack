import { CategoryCreateComponent } from './../category-create/category-create.component';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { MatDialog } from '@angular/material/dialog';
import { Component, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-categories-mobile',
  templateUrl: './categories-mobile.component.html',
  styleUrls: ['./categories-mobile.component.scss']
})
export class CategoriesMobileComponent extends ChildBaseComponent<CategoryCreateComponent> implements AfterViewInit {
  constructor(public dialog: MatDialog) {
    super(dialog, CategoryCreateComponent);
  }

  ngAfterViewInit(): void {
  }

  public endUpdate() {
  }

  public init() {
  }

}
