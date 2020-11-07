import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { MatDialog } from '@angular/material/dialog';
import { TableComponent } from '@app/_components/helpers/table/table.component';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, AfterViewInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-categories-desktop',
  templateUrl: './categories-desktop.component.html',
  styleUrls: ['./categories-desktop.component.scss']
})
export class CategoriesDesktopComponent extends ChildBaseComponent implements AfterViewInit {
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
