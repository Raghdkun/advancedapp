import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import 'package:injectable/injectable.dart';

import '../../../../core/usecases/usecase.dart';
import '../../domain/entities/counter.dart';
import '../../domain/usecases/decrement_counter.dart';
import '../../domain/usecases/get_counter.dart';
import '../../domain/usecases/increment_counter.dart';
import '../../domain/usecases/reset_counter.dart';

part 'counter_event.dart';
part 'counter_state.dart';

@injectable
class CounterBloc extends Bloc<CounterEvent, CounterState> {
  final GetCounter getCounter;
  final IncrementCounter incrementCounter;
  final DecrementCounter decrementCounter;
  final ResetCounter resetCounter;

  CounterBloc({
    required this.getCounter,
    required this.incrementCounter,
    required this.decrementCounter,
    required this.resetCounter,
  }) : super(CounterInitial()) {
    on<LoadCounter>(_onLoadCounter);
    on<IncrementCounterEvent>(_onIncrementCounter);
    on<DecrementCounterEvent>(_onDecrementCounter);
    on<ResetCounterEvent>(_onResetCounter);
  }

  Future<void> _onLoadCounter(
    LoadCounter event,
    Emitter<CounterState> emit,
  ) async {
    emit(CounterLoading());
    final result = await getCounter(NoParams());
    result.fold(
      (failure) => emit(CounterError(failure.message)),
      (counter) => emit(CounterLoaded(counter)),
    );
  }

  Future<void> _onIncrementCounter(
    IncrementCounterEvent event,
    Emitter<CounterState> emit,
  ) async {
    final result = await incrementCounter(NoParams());
    result.fold(
      (failure) => emit(CounterError(failure.message)),
      (counter) => emit(CounterLoaded(counter)),
    );
  }

  Future<void> _onDecrementCounter(
    DecrementCounterEvent event,
    Emitter<CounterState> emit,
  ) async {
    final result = await decrementCounter(NoParams());
    result.fold(
      (failure) => emit(CounterError(failure.message)),
      (counter) => emit(CounterLoaded(counter)),
    );
  }

  Future<void> _onResetCounter(
    ResetCounterEvent event,
    Emitter<CounterState> emit,
  ) async {
    final result = await resetCounter(NoParams());
    result.fold(
      (failure) => emit(CounterError(failure.message)),
      (counter) => emit(CounterLoaded(counter)),
    );
  }
}
