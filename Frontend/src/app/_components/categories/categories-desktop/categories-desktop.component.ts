import { MatDialog } from '@angular/material/dialog';
import { TableComponent } from '@app/_components/helpers/table/table.component';
import { CategoryCreateComponent } from './../category-create/category-create.component';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, OnInit, AfterViewInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-categories-desktop',
  templateUrl: './categories-desktop.component.html',
  styleUrls: ['./categories-desktop.component.scss']
})
export class CategoriesDesktopComponent extends ChildBaseComponent<CategoryCreateComponent> implements AfterViewInit {
  @ViewChild('Table') tableComponent: TableComponent;
  constructor(public dialog: MatDialog) {
    super(dialog, CategoryCreateComponent);
  }

  ngAfterViewInit(): void {
    this.tableComponent.UpdateComponentOrTemplateRef(CategoryCreateComponent);
  }

  public endUpdate() {
    this.tableComponent.endUpdate();
  }

  public init() {
  }

}
