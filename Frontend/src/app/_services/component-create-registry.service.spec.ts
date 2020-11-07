import { TestBed } from '@angular/core/testing';

import { ComponentCreateRegistryService } from './component-create-registry.service';

describe('ComponentCreateRegistryService', () => {
  let service: ComponentCreateRegistryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ComponentCreateRegistryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
