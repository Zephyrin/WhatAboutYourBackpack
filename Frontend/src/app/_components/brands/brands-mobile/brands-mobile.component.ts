import { BrandCreateComponent } from '@app/_components/brands/brand-create/brand-create.component';

import { MatDialog } from '@angular/material/dialog';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-brands-mobile',
  templateUrl: './brands-mobile.component.html',
  styleUrls: ['./brands-mobile.component.scss']
})
export class BrandsMobileComponent extends ChildBaseComponent<BrandCreateComponent> implements AfterViewInit {
  constructor(public dialog: MatDialog) {
    super(dialog, BrandCreateComponent);
  }

  ngAfterViewInit(): void {
  }

  public endUpdate() {
  }

  public init() {
  }
}
