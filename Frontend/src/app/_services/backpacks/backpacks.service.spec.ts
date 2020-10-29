import { TestBed } from '@angular/core/testing';

import { BackpacksService } from './backpacks.service';

describe('BackpacksService', () => {
  let service: BackpacksService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BackpacksService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
