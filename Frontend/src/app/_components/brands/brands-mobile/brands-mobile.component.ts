import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { MatDialog } from '@angular/material/dialog';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-brands-mobile',
  templateUrl: './brands-mobile.component.html',
  styleUrls: ['./brands-mobile.component.scss']
})
export class BrandsMobileComponent extends ChildBaseComponent implements AfterViewInit {
  constructor(public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService) {
    super(dialog, createRegistry);
  }

  ngAfterViewInit(): void {
  }

  public endUpdate() {
  }

  public init() {
  }
}
