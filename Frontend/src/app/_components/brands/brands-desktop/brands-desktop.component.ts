import { BrandCreateComponent } from '@app/_components/brands/brand-create/brand-create.component';
import { TableComponent } from '@app/_components/helpers/table/table.component';

import { MatDialog } from '@angular/material/dialog';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, ViewChild, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-brands-desktop',
  templateUrl: './brands-desktop.component.html',
  styleUrls: ['./brands-desktop.component.scss']
})
export class BrandsDesktopComponent extends ChildBaseComponent<BrandCreateComponent> implements AfterViewInit {
  @ViewChild('Table') tableComponent: TableComponent;
  constructor(public dialog: MatDialog) {
    super(dialog, BrandCreateComponent);
  }

  ngAfterViewInit(): void {
    this.tableComponent.UpdateComponentOrTemplateRef(BrandCreateComponent);
  }

  public endUpdate() {
    this.tableComponent.endUpdate();
  }

  public init() {
  }

}
