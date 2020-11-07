import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { TableComponent } from '@app/_components/helpers/table/table.component';

import { MatDialog } from '@angular/material/dialog';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, ViewChild, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-brands-desktop',
  templateUrl: './brands-desktop.component.html',
  styleUrls: ['./brands-desktop.component.scss']
})
export class BrandsDesktopComponent extends ChildBaseComponent implements AfterViewInit {
  @ViewChild('Table') tableComponent: TableComponent;
  constructor(public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService) {
    super(dialog, createRegistry);
  }

  ngAfterViewInit(): void {
  }

  public endUpdate() {
    this.tableComponent.endUpdate();
  }

  public init() {
  }

}
